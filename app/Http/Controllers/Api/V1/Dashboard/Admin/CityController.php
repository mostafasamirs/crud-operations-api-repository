<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\cities\StoreCitiesRequest;
use App\Http\Requests\cities\UpdateCitiesRequest;
use App\Http\Resources\Dashboard\AdminData\Cities\CitiesResource;
use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = CitiesResource::class;

    /**
     * SOLID -> Dependency Inversion Principle. (DIP) (BlogRepositoryInterface)
     * High-Level Modules should not depend on low-level modules .
     **/
    public function __construct(protected CityRepositoryInterface $cityRepository)
    {
        foreach (City::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * List cities with pagination and trashed count.
     */
    public function index()
    {
        $cities = $this->cityRepository->index(config('app.paginate'));
        $trashedCount = $this->cityRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($cities)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::city.cities'));

    }


    /**
     * @param StoreCitiesRequest $request
     * @return JsonResponse
     * Store a new city with translations.
     */
    public function store(StoreCitiesRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations']);
            $city = $this->cityRepository->create($data);
            $this->cityRepository->addTranslations($city->id, $translations);
            DB::commit();
            return $this->returnData(new CitiesResource($city), lang('api::city.city_created_successfully'));
        } catch (Exception $exception) {
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @param City $uuid
     * @return JsonResponse
     * Show city details.
     */
    public function show(string $uuid)
    {
        $city = $this->cityRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($city), lang('api::city.city_show_successfully'));
    }


    /**
     * @param City $uuid
     * @return JsonResponse
     * Soft delete a city.
     */
    public function destroy(string $uuid)
    {
        $this->cityRepository->destroy($uuid);
        return $this->successMessage(lang('api::city.city_archived_successfully'));
    }

    /**
     * @return JsonResponse
     * List archived (soft deleted) cities.
     */
    public function archive()
    {
        $archivedBlogs = $this->cityRepository->getArchived(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($archivedBlogs), lang('api::city.archived_cities'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Restore a soft deleted city.
     */
    public function restore($uuid)
    {
        $city = $this->cityRepository->restore($uuid);
        return $this->returnData(new (self::RESOURCE)($city), lang('api::city.city_restored_successfully'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Permanently delete a soft deleted city.
     */
    public function forceDelete($uuid)
    {

        try {
            DB::beginTransaction();
            $this->cityRepository->forceDelete($uuid);
            DB::commit();
            return $this->successMessage(lang('api::city.city_deleted_successfully'));
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return $this->NotFound();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change city status (active/inactive).
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $city = $this->cityRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($city), lang('api::general.change_status_successfully'));
    }


    /**
     * @param UpdateCitiesRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update city details, including translations.
     */
    public function update(UpdateCitiesRequest $request, $uuid)
    {

        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // Update city using the repository
            $city = $this->cityRepository->update($uuid, $data);

            // Update translations
            $this->cityRepository->updateTranslations($city->id, $translations);

            DB::commit();
            return $this->returnData(new (self::RESOURCE)($city), lang('api::city.city_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

}
