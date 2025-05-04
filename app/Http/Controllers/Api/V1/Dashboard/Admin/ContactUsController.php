<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\AdminData\CountactUs\CountactUsResource;
use App\Models\ContactUs;
use App\Repositories\Interfaces\ContactUsRepositoryInterface;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;

class ContactUsController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = CountactUsResource::class;

    public function __construct(protected ContactUsRepositoryInterface $faqRepository)
    {
        foreach (ContactUs::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * List contact messages with pagination.
     */
    public function index()
    {

        $faqs = $this->faqRepository->index(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($faqs)->response()->getData(), lang('api::contactUs.contactUs'));

    }


    /**
     * @param ContactUs $contactUs
     * @return JsonResponse
     * Show details of a specific contact message.
     */
    public function show(string $uuid)
    {
        $contactUs = $this->faqRepository->show($uuid);
        return $this->returnData(new (self::RESOURCE)($contactUs), lang('api::contactUs.show_contactUs'));
    }
}
