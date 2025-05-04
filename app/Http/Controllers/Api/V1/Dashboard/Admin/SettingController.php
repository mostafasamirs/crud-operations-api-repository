<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateSettingRequest;
use App\Http\Resources\Dashboard\AdminData\settings\SettingsResource;
use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Traits\ApiTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class SettingController extends Controller
{
    use ApiTrait;

    protected const RESOURCE = SettingsResource::class;

    public function __construct(protected SettingRepositoryInterface $blogRepository)
    {
        foreach (Setting::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * Retrieve a paginated list of settings.
     */
    public function index()
    {
        $settings = $this->blogRepository->index(config('app.paginate'));
        return $this->returnData((self::RESOURCE)::collection($settings)->response()->getData(), lang('api::setting.settings'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * Update multiple settings based on the provided data.
     */
    public function update(UpdateSettingRequest $request)
    {
        $validatedData = $request->validated();
        $updatedSettings = $this->blogRepository->update($validatedData);
        return response()->json(['status' => true, 'message' => __('api::settings.setting_updated_successfully'), 'data' => $updatedSettings,]);
    }
}
