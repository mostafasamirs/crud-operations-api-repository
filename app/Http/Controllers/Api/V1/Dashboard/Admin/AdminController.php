<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Resources\Dashboard\AdminData\Admin\AdminResources;
use App\Models\Admin;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use ApiTrait;

    public function __construct()
    {
        foreach (Admin::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * List active admins with pagination and trashed count.
     */
    public function index()
    {
        $admins = Admin::withoutTrashed()->paginate(config('app.paginate'));
        $trashedCount = Admin::onlyTrashed()->count();
        return $this->returnData(AdminResources::collection($admins)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::admin.admins'));

    }

    /**
     * Store a new admin with translations, image, and role assignment.
     * @param StoreAdminRequest $request
     * @return JsonResponse
     */
    public function store(StoreAdminRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image'], $data['confirm_password']);
            $admin = Admin::create($data);
            $admin->translations()->createMany($translations);
            addImage($request, $admin, 'image');
            $admin->assignRole($data['role']);
            DB::commit();
            return $this->returnData(new AdminResources($admin), lang('api::admin.admin_created_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }

    }


    /**
     * @param Admin $admin
     * @return JsonResponse
     * Show admin details.
     */
    public function show(Admin $admin)
    {
        return $this->returnData(new AdminResources($admin), lang('api::admin.admin_show_successfully'));
    }


    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change admin status (active/inactive).
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $admin = Admin::where('uuid', $uuid)->firstOrFail();
        $admin->update(['is_active' => $request->is_active]);
        return $this->returnData(new AdminResources($admin), lang('api::general.change_status_successfully'));
    }

    /**
     * @param UpdateAdminRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update admin details, including translations, image, and roles.
     */
    public function update(UpdateAdminRequest $request, $uuid)
    {
        $admin = Admin::where('uuid', $uuid)->firstOrFail();
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image'], $data['confirm_password']);
            $admin->update($data);
            $admin->translations()->upsert($translations, ['locale']);
            updateImage($request, $admin, 'image');
            $admin->syncRoles($data['role'] ?? []);
            DB::commit();
            return $this->returnData(new AdminResources($admin), lang('api::admin.admin_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param Admin $admin
     * @return JsonResponse
     * Soft delete an admin.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return $this->successMessage(lang('api::admin.admin_deleted_successfully'));
    }

    /**
     * @return JsonResponse
     * List archived (soft deleted) admins.
     */
    public function archive()
    {
        $archivedAdmin = Admin::onlyTrashed()->paginate(config('app.paginate'));
        return $this->returnData(AdminResources::collection($archivedAdmin), lang('api::admin.admin_archived_successfully'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Restore a soft deleted admin.
     */
    public function restore($uuid)
    {
        $restoreAdmin = Admin::onlyTrashed()->where('uuid', $uuid)->firstOrFail();
        if (!$restoreAdmin) {
            return $this->errorMessage(lang('api::general.not_found'), 404);
        }
        $restoreAdmin->restore();
        return $this->returnData(new AdminResources($restoreAdmin), lang('api::admin.admin_restored_successfully'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Permanently delete a soft deleted admin.
     */
    public function forceDelete($uuid)
    {
        try {
            DB::beginTransaction();
            $forceDeleteAdmin = Admin::onlyTrashed()->where('uuid', $uuid)->firstOrFail();
            deleteMedia($forceDeleteAdmin, 'image');
            $forceDeleteAdmin->forceDelete();
            DB::commit();
            return $this->successMessage(lang('api::admin.admin_deleted_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }
}
