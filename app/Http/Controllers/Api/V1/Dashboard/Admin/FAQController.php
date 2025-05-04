<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fcq\StoreFcqRequest;
use App\Http\Requests\Fcq\UpdateFcqRequest;
use App\Http\Resources\Dashboard\AdminData\Blogs\BlogsResource;
use App\Http\Resources\Dashboard\AdminData\FAQS\FAQSResource;
use App\Models\Blog;
use App\Models\FAQ;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use App\Repositories\Interfaces\FAQRepositoryInterface;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class FAQController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = FAQSResource::class;

    public function __construct(protected FAQRepositoryInterface $faqRepository)
    {
        foreach (FAQ::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * Retrieve a paginated list of FAQs.
     */
    public function index()
    {
        $faqs = $this->faqRepository->index(config('app.paginate'));
        $trashedCount = $this->faqRepository->getTrashedCount();
        return $this->returnData((self::RESOURCE)::collection($faqs)->additional(['trashed_count' => $trashedCount])->response()->getData(), lang('api::faq.faqs'));
    }


    /**
     * @param StoreFcqRequest $request
     * @return JsonResponse
     * Store a new FAQ with translations.
     */
    public function store(StoreFcqRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations']);
            $faq = $this->faqRepository->create($data);
            $this->faqRepository->addTranslations($faq->id, $translations);
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($faq), lang('api::faq.faq_created_successfully'));
        } catch (Exception $exception) {
            return $this->errorMessage($exception->getMessage());
        }
    }

    /**
     * @param FAQ $faq
     * @return JsonResponse
     * Display a specific FAQ.
     */
    public function show(string $uuid)
    {
        $faq = $this->faqRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($faq), lang('api::faq.faq_show_successfully'));
    }


    /**
     * @param string $uuid
     * @param Request $request
     * @return JsonResponse
     * Change the status (active/inactive) of an FAQ.
     */
    public function changeStatus(string $uuid, Request $request)
    {
        $faq = $this->faqRepository->changeStatus($uuid, $request->is_active);
        return $this->returnData(new (self::RESOURCE)($faq), lang('api::general.change_status_successfully'));
    }

    /**
     * @param UpdateFcqRequest $request
     * @param $uuid
     * @return JsonResponse
     * Update an existing FAQ with translations and an image.
     */
    public function update(UpdateFcqRequest $request, $uuid)
    {
        $faq = FAQ::where('uuid', $uuid)->firstOrFail();
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $translations = $data['translations'] ?? [];
            unset($data['translations']);
            $faq = $this->faqRepository->update($uuid, $data);
            $this->faqRepository->updateTranslations($faq->id, $translations);
            DB::commit();
            return $this->returnData(new (self::RESOURCE)($faq), lang('api::faq.faq_updated_successfully'));
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }

    /**
     * @param FAQ $faq
     * @return JsonResponse
     * Soft delete an FAQ.
     */
    public function destroy(string $uuid)
    {
        $this->faqRepository->destroy($uuid);
        return $this->successMessage(lang('api::faq.faq_deleted_successfully'));
    }

}
