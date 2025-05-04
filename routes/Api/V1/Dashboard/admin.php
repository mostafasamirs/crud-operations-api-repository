<?php

use App\Http\Controllers\Api\V1\Dashboard\Admin\ActiveLogsController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\AdminController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\BlogController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\CityController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\ContactUsController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\CountryController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\FAQController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\NewsArticleController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\NotificationController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\RoleController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\SettingController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\SliderController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\SubPageController;
use App\Http\Controllers\Api\V1\Dashboard\Admin\TranslationController;
use Illuminate\Support\Facades\Route;

//Routes News
Route::apiResource('news', NewsArticleController::class)->except('update')->scoped(['news' => 'uuid']);
Route::post('news/{uuid}', [NewsArticleController::class, 'update']);
Route::post('change-status-news/{uuid}', [NewsArticleController::class, 'changeStatus']);
// Archive  Routes News
Route::get('news-archive', [NewsArticleController::class, 'archive']);
Route::post('news-restore/{uuid}', [NewsArticleController::class, 'restore']);
Route::delete('news-force-delete/{uuid}', [NewsArticleController::class, 'forceDelete']);
//Routes News

//Routes blogs
Route::apiResource('blogs', BlogController::class)->except('update')->scoped(['blog' => 'uuid']);
Route::post('blogs/{uuid}', [BlogController::class, 'update']);
Route::post('change-status-blogs/{uuid}', [BlogController::class, 'changeStatus']);
// Archive  Routes blogs
Route::get('blogs-archive', [BlogController::class, 'archive']);
Route::post('blogs-restore/{uuid}', [BlogController::class, 'restore']);
Route::delete('blogs-force-delete/{uuid}', [BlogController::class, 'forceDelete']);
//Routes blogs

//Routes sub_pages
Route::apiResource('sub-pages', SubPageController::class)->except('update')->scoped(['sub-pages' => 'uuid']);
Route::post('sub-pages/{uuid}', [SubPageController::class, 'update']);
Route::post('change-status-sub-pages/{uuid}', [SubPageController::class, 'changeStatus']);
// Archive  Routes sub_pages
Route::get('sub-pages-archive', [SubPageController::class, 'archive']);
Route::post('sub-pages-restore/{uuid}', [SubPageController::class, 'restore']);
Route::delete('sub-pages-force-delete/{uuid}', [SubPageController::class, 'forceDelete']);
//Routes sub_pages

//Routes sliders
Route::apiResource('sliders', SliderController::class)->except('update')->scoped(['slider' => 'uuid']);
Route::post('sliders/{uuid}', [SliderController::class, 'update']);
Route::post('change-status-sliders/{uuid}', [SliderController::class, 'changeStatus']);
// Archive  Routes sliders
Route::get('sliders-archive', [SliderController::class, 'archive']);
Route::post('sliders-restore/{uuid}', [SliderController::class, 'restore']);
Route::delete('sliders-force-delete/{uuid}', [SliderController::class, 'forceDelete']);
//Routes sliders
//Routes faqs
Route::apiResource('faqs', FAQController::class)->except('update')->scoped(['faq' => 'uuid']);
Route::post('faqs/{uuid}', [FAQController::class, 'update']);
Route::post('change-status-faqs/{uuid}', [FAQController::class, 'changeStatus']);
// Archive  Routes faqs
Route::get('faqs-archive', [FAQController::class, 'archive']);
Route::post('faqs-restore/{uuid}', [FAQController::class, 'restore']);
Route::delete('faqs-force-delete/{uuid}', [FAQController::class, 'forceDelete']);
//Routes faqs
//Contact us route
Route::get('contact-us', [ContactUsController::class, 'index']);
Route::get('contact-us/{contact_us:uuid}', [ContactUsController::class, 'show']);


//countries Route
Route::resource('countries', CountryController::class)->except('update')->scoped(['country' => 'uuid']);
Route::post('countries/{uuid}', [CountryController::class, 'update']);
Route::get('countries-archive', [CountryController::class, 'archive']);
Route::post('countries-restore/{country}', [CountryController::class, 'restore']);
Route::delete('countries-force-delete/{country}', [CountryController::class, 'forceDelete']);

//cities Route
Route::resource('cities', CityController::class)->except('update')->scoped(['city' => 'uuid']);
Route::post('cities/{uuid}', [CityController::class, 'update']);
Route::get('cities-archive', [CityController::class, 'archive']);
Route::post('cities-restore/{city}', [CityController::class, 'restore']);
Route::delete('cities-force-delete/{city}', [CityController::class, 'forceDelete']);
Route::post('change-status-cities/{uuid}', [CityController::class, 'changeStatus']);

//Setting Route
Route::get('settings', [SettingController::class, 'index']);
Route::put('settings-update', [SettingController::class, 'update']);

//admins Route

Route::resource('admins', AdminController::class)->except('update')->scoped(['admin' => 'uuid']);
Route::post('admins/{uuid}', [AdminController::class, 'update']);
Route::get('admins-archive', [AdminController::class, 'archive']);
Route::post('admins-restore/{admin}', [AdminController::class, 'restore']);
Route::delete('admins-force-delete/{admin}', [AdminController::class, 'forceDelete']);
Route::post('admins/change-password/{uuid}', [AdminController::class, 'updatePassword']);
Route::post('change-status-admins/{uuid}', [AdminController::class, 'changeStatus']);


Route::resource('roles', RoleController::class)->except('update');
Route::post('roles/{id}', [RoleController::class, 'update']);
Route::get('permissions', [RoleController::class, 'getPermissions']);


//notification Route
Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/create', [NotificationController::class, 'create']);
Route::get('notifications/{notification:uuid}', [NotificationController::class, 'show']);
Route::post('notifications/resend/{notification:uuid}', [NotificationController::class, 'resend']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::delete('notifications/destroy/{notification:uuid}', [NotificationController::class, 'destroy']);

//translations Route
Route::get('translations', [TranslationController::class, 'index']);
Route::put('translations-update/{key}', [TranslationController::class, 'update']);

//translations Route
Route::get('active-logs', ActiveLogsController::class);
