<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubPage\StoreSubPageRequest;
use App\Http\Requests\SubPage\UpdateSubPageRequest;
use App\Http\Resources\Dashboard\AdminData\SubPage\SubPageResource;
use App\Models\subPage;
use App\Repositories\Interfaces\SubPageRepositoryInterface;
use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SubPageController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = SubPageResource::class;

    public function __construct(protected SubPageRepositoryInterface $subPagesRepository)
    {
        foreach (subPage::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }


    /**
     * @return JsonResponse
     * Retrieve a paginated list of sub-pages with the count of archived sub-pages.
     */
    public function index()
    {
        $subPages = $this->subPagesRepository->index(config('app.paginate'));
        $trashedCount = $this->subPagesRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($subPages)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::subPage.subPages'));
    }


    /**
     * @param StoreSubPageRequest $request
     * @return JsonResponse
     * Store a new sub-page with translations and an image.
     */
    public function store(StoreSubPageRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image']);
            $subPage = $this->subPagesRepository->create($data);
            $this->subPagesRepository->addTranslations($subPage->id, $translations);
            addImage($request, $subPage, 'image');
            DB::commit();
            return $this->returnData(new SubPageResource($subPage), lang('api::subPage.subPage_created_successfully'));
        } catch (Exception $exception) {
            return $this->errorMessage($exception->getMessage());
        }

    }


    /**
     * @param subPage $subPage
     * @return JsonResponse
     * Show details of a specific sub-page.
     */
    public function show(string $uuid)
    {
        $subPage = $this->subPagesRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($subPage), lang('api::subPage.subPage_show_successfully'));
    }


    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change the activation status of a sub-page.
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $subPage = $this->subPagesRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($subPage), lang('api::general.change_status_successfully'));
    }


    /**
     * @param UpdateSubPageRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update an existing sub-page with translations and an image.
     */
    public function update(UpdateSubPageRequest $request, $uuid)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['image']);
            $subPage = $this->subPagesRepository->update($uuid, $data);
            $this->subPagesRepository->updateTranslations($subPage->id, $translations);
            updateImage($request, $subPage, 'image');
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($subPage), lang('api::subPage.updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

    /**
     * @param subPage $subPage
     * @return JsonResponse
     * Soft delete (archive) a sub-page.
     */
    public function destroy(string $uuid)
    {
        $this->subPagesRepository->destroy($uuid);
        return $this->successMessage(lang('api::slider.subPage_archived_successfully'));
    }


    /**
     * @return JsonResponse
     * Retrieve a paginated list of archived (deleted) sub-pages.
     */
    public function archive()
    {
        $archivedSubPage = $this->subPagesRepository->getArchived(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($archivedSubPage), lang('api::subPage.archived_subPages'));
    }


    /**
     * @param $uuid
     * @return JsonResponse
     * Restore a soft-deleted (archived) sub-page.
     */
    public function restore(string $uuid)
    {
        $subPages = $this->subPagesRepository->restore($uuid);
        return $this->returnData(new (self::RESOURCE)($subPages), lang('api::subPage.subPage_restored_successfully'));
    }


    /**
     * @param $uuid
     * @return JsonResponse
     * Permanently delete a soft-deleted sub-page and its associated image.
     */
    public function forceDelete($uuid)
    {
        try {
            DB::beginTransaction();
            $subPages = $this->subPagesRepository->forceDelete($uuid);
            deleteMedia($subPages, 'image');
            DB::commit();
            return $this->successMessage(lang('api::subPage.subPage_deleted_successfully'));
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return $this->NotFound();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

}
