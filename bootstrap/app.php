<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            //api
            Route::middleware(['api', Localization::class])->prefix('api/v1/auth')->group(base_path('routes/Api/V1/Dashboard/auth.php'));
            Route::middleware(['api', Localization::class, 'auth:sanctum', AdminMiddleware::class])->prefix('api/v1/admin')->group(base_path('routes/Api/V1/Dashboard/admin.php'));
            Route::middleware(['api', Localization::class])->prefix('api/v1/employee')->group(base_path('routes/Api/V1/Dashboard/employee.php'));
            Route::middleware(['api', Localization::class])->prefix('api/v1/vendor')->group(base_path('routes/Api/V1/Dashboard/vendor.php'));
            Route::middleware(['api', Localization::class])->prefix('api/v1/general')->group(base_path('routes/Api/V1/Dashboard/general.php'));
            //api Client Mobile
            Route::middleware(['api', Localization::class])->prefix('api/v1/client/auth')->group(base_path('routes/Api/V1/Client/auth.php'));
            Route::middleware(['api', Localization::class])->prefix('api/v1/client')->group(base_path('routes/Api/V1/Client/client.php'));
            //api Client Mobile
            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));
        }
//        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'localize' => LaravelLocalizationRoutes::class,
            'localizationRedirect' => LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect' => LocaleSessionRedirect::class,
            'localeCookieRedirect' => LocaleCookieRedirect::class,
            'localeViewPath' => LaravelLocalizationViewPath::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'status' => false,
                'message' => __('general.data_not_found_check_id'),
                'data' => null
            ], 404);
        });
    })->create();
