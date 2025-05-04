<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Dashboard\AdminData\Permissions\PermissionResource;
use App\Http\Resources\Dashboard\AdminData\Role\RoleResources;
use App\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = PermissionResource::class;

    public function __construct(protected RoleRepositoryInterface $roleRepository)
    {
        foreach (Role::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * Retrieve all permissions for the admin guard, grouped by category.
     */
    public function getPermissions()
    {
        $permissions = $this->roleRepository->getGroupedPermissions();
        return $this->returnData(
            ['permissions' => PermissionResource::collection($permissions)],
            lang('api::role.show_permissions')
        );
    }


    /**
     * @return JsonResponse
     * Retrieve a paginated list of roles.
     */
    public function index()
    {
        $roles = $this->roleRepository->index(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($roles)->response()->getData(), lang('api::role.roles'));

    }


    /**
     * @param StoreRoleRequest $request
     * @return JsonResponse
     * Store a new role with assigned permissions.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $role = $this->roleRepository->create($data);
            $this->roleRepository->addRoles($role, $data);
            DB::commit();
            return $this->returnData(new RoleResources($role), lang('api::role.role_created_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param Role $role
     * @return JsonResponse
     * Display a specific role.
     */
    public function show(string $uuid)
    {
        $role = $this->roleRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($role), lang('api::role.role_show_successfully'));
    }


    /**
     * @param UpdateRoleRequest $request
     * @param $id
     * @return JsonResponse
     * Update an existing role and its permissions.
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $role = $this->roleRepository->update($id, $data);
            $this->roleRepository->updateRoles($role->id, $data);
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($role), lang('api::role.role_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }

    }


    /**
     * @param Role $role
     * @return JsonResponse
     * Delete a role and remove its permissions.
     */
    public function destroy(string $uuid)
    {
        $this->roleRepository->destroy($uuid);
        return $this->successMessage(lang('api::role.role_deleted_successfully'));
    }

}
