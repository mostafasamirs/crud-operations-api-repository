<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\AdminData\Translation\TranslationResources;
use App\Models\Translation;
use App\Services\TranslationService;
use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controllers\Middleware;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TranslationController extends Controller
{
    use ApiTrait;

    public function __construct()
    {
        foreach (Translation::getPermissions() as $permission => $methods) {
            $middleware = new Middleware("permission:$permission");
            $middleware->only($methods);
        }
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * Retrieve paginated translations, handling both query and array results.
     */
    public function index()
    {
        $query = TranslationService::retrieve(true);

        $translations = $query instanceof Builder ? $query->paginate(config('app.paginate', 10))
            : new LengthAwarePaginator(
                collect($query)->forPage($page = request('page', 1), $perPage = config('app.paginate', 15)),
                count($query),
                $perPage,
                $page,
                ['path' => request()->url()]
            );

        return $this->returnData(
            TranslationResources::collection($translations)->response()->getData(),
            lang('api::translation.translations')
        );
    }


    /**
     * @param $key
     * @return JsonResponse
     * Update (or create) a translation for the given key and locale.
     */
    public function update($key)
    {
        $locale = request('locale');

        if ($locale == 'ar') {
            $value = request('value', 'انقر لاضافة الترجمة ');
        } else {
            $value = request('value', 'Click to Add translation');
        }
        $translation = Translation::firstOrCreate(['key' => $key])
            ->translations()
            ->updateOrCreate(
                ['locale' => $locale],
                ['value' => $value]
            );
        return $this->returnData(new TranslationResources($translation), lang('api::translation.translation_updated_successfully'));

    }

}
