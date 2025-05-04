<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Countries\StoreCountriesRequest;
use App\Http\Requests\Countries\UpdateCountriesRequest;
use App\Http\Resources\Dashboard\AdminData\Countries\CountriesResource;
use App\Models\Country;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = CountriesResource::class;

    public function __construct(protected CountryRepositoryInterface $countryRepository)
    {
        foreach (Country::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }


    /**
     * @return JsonResponse
     * List countries with pagination and trashed count.
     */
    public function index()
    {
        $countries = $this->countryRepository->index(config('app.paginate'));
        $trashedCount = $this->countryRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($countries)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::country.countries'));

    }


    /**
     * @param StoreCountriesRequest $request
     * @return JsonResponse
     * Store a new country with translations and flag.
     */
    public function store(StoreCountriesRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations'], $data['flag']);
            $country = $this->countryRepository->create($data);
            $this->countryRepository->addTranslations($country->id, $translations);
            addImage($request, $country, 'flag');
            DB::commit();
            return $this->returnData(new CountriesResource($country), lang('api::country.country_created_successfully'));
        } catch (Exception $exception) {
            return $this->errorMessage($exception->getMessage());
        }
    }

    /**
     * @param Country $country
     * @return JsonResponse
     * Show details of a specific country.
     */
    public function show(string $uuid)
    {
        $country = $this->countryRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($country), lang('api::country.country_show_successfully'));
    }

    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change the status (active/inactive) of a country.
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $country = $this->countryRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($country), lang('api::general.change_status_successfully'));
    }


    /**
     * @param UpdateCountriesRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update country details, including translations and flag.
     */
    public function update(UpdateCountriesRequest $request, $uuid)
    {
        {
            $country = Country::where('uuid', $uuid)->firstOrFail();
            try {
                DB::beginTransaction();
                $data = $request->validated();
                $translations = $data['translations'] ?? [];
                unset($data['translations'], $data['flag']);
                // Update country using the repository
                $country = $this->countryRepository->update($uuid, $data);
                // Update translations
                $this->countryRepository->updateTranslations($country->id, $translations);
                updateImage($request, $country, 'flag');
                DB::commit();
                return $this->returnData(new  (self::RESOURCE)($country), lang('api::country.country_updated_successfully'));
            } catch (Exception $exception) {
                DB::rollBack();
                return $this->errorMessage($exception->getMessage());
            }
        }

    }


    /**
     * @param Country $country
     * @return JsonResponse
     * Soft delete (archive) a country.
     */
    public function destroy(string $uuid)
    {
        $this->countryRepository->destroy($uuid);
        return $this->successMessage(lang('api::country.country_archived_successfully'));
    }

    /**
     * @return JsonResponse
     * List archived (soft-deleted) countries with pagination.
     */
    public function archive()
    {
        $archivedBlogs = $this->countryRepository->getArchived(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($archivedBlogs), lang('api::country.archived_countries'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Restore a previously archived country.
     */
    public function restore($uuid)
    {
        $country = $this->countryRepository->restore($uuid);
        return $this->returnData(new (self::RESOURCE)($country), lang('api::country.country_restored_successfully'));
    }

    /**
     * @param $uuid
     * @return JsonResponse
     * Permanently delete a country and its associated media.
     */
    public function forceDelete($uuid)
    {
        try {
            DB::beginTransaction();
            $country = $this->countryRepository->forceDelete($uuid);
            deleteMedia($country, 'image');
            DB::commit();
            return $this->successMessage(lang('api::country.country_deleted_successfully'));
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return $this->NotFound();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }
}
