<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\StoreSliderRequest;
use App\Http\Requests\Slider\UpdateSliderRequest;
use App\Http\Resources\Dashboard\AdminData\Slider\SliderResource;
use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class SliderController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = SliderResource::class;


    public function __construct(protected SliderRepositoryInterface $sliderRepository)
    {
        foreach (Slider::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * Retrieve a paginated list of sliders with the count of archived sliders.
     */
    public function index()
    {
        $sliders = $this->sliderRepository->index(config('app.paginate'));
        $trashedCount = $this->sliderRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($sliders)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::slider.sliders'));

    }


    /**
     * @param StoreSliderRequest $request
     * @return JsonResponse
     * Store a new slider with translations and images.
     */
    public function store(StoreSliderRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['website_image'], $data['mobile_image'], $data['translations']);
            $slider = Slider::create($data);
            $slider = $this->sliderRepository->create($data);
            $this->sliderRepository->addTranslations($slider->id, $translations);
            addImage($request, $slider, 'website_image');
            addImage($request, $slider, 'mobile_image');
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($slider), lang('api::slider.slider_created_successfully'));
        } catch (Exception $exception) {
            return $this->errorMessage($exception->getMessage());
        }

    }


    /**
     * @param Slider $slider
     * @return JsonResponse
     * Show details of a specific slider.
     */
    public function show(string $uuid)
    {
        $slider = $this->sliderRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($slider), lang('api::slider.slider_show_successfully'));
    }


    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change the activation status of a slider.
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $slider = $this->sliderRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($slider), lang('api::general.change_status_successfully'));
    }


    /**
     * @param UpdateSliderRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update an existing slider with translations and images.
     */
    public function update(UpdateSliderRequest $request, $uuid)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['website_image'], $data['mobile_image'], $data['translations']);
            $slider = $this->sliderRepository->update($uuid, $data);
            $this->sliderRepository->updateTranslations($slider->id, $translations);
            collect(['website_image', 'mobile_image'])->each(fn($collection_name) => updateImage($request, $slider, $collection_name));
//            updateImage($request, $slider, 'website_image');
//            updateImage($request, $slider, 'mobile_image');
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($slider), lang('api::slider.slider_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    /**
     * @return JsonResponse
     * Retrieve a paginated list of archived (deleted) sliders.
     */
    public function archive()
    {
        $archivedBlogs = $this->sliderRepository->getArchived(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($archivedBlogs), lang('api::slider.archived_sliders'));
    }


    /**
     * @param Slider $slider
     * @return JsonResponse
     * Soft delete (archive) a slider.
     */
    public function destroy(string $uuid)
    {
        $this->sliderRepository->destroy($uuid);
        return $this->successMessage(lang('api::slider.slider_archived_successfully'));
    }


    /**
     * @param $uuid
     * @return JsonResponse
     * Restore a soft-deleted (archived) slider.
     */
    public function restore(string $uuid)
    {
        $slider = $this->sliderRepository->restore($uuid);
        return $this->returnData(new (self::RESOURCE)($slider), lang('api::slider.slider_restored_successfully'));
    }


    /**
     * @param $uuid
     * @return JsonResponse
     * Permanently delete a soft-deleted slider and its associated images.
     */
    public function forceDelete($uuid)
    {

        try {
            DB::beginTransaction();
            $forceDeleteSlider = $this->sliderRepository->forceDelete($uuid);
            deleteMedia($forceDeleteSlider, 'website_image');
            deleteMedia($forceDeleteSlider, 'mobile_image');
            $forceDeleteSlider->forceDelete();
            DB::commit();
            return $this->successMessage(lang('api::slider.slider_deleted_successfully'));
        } catch (ModelNotFoundException) {
            DB::rollBack();
            return $this->NotFound();
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }
}
