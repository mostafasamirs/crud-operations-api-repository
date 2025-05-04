<?php

use App\Http\Controllers\Api\V1\Dashboard\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\Dashboard\Auth\LoginController;
use App\Http\Controllers\Api\V1\Dashboard\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Dashboard\Auth\ResetPasswordController;
use App\Http\Controllers\Api\V1\Dashboard\Auth\VerificationOtp;
use Illuminate\Support\Facades\Route;


Route::post('login', LoginController::class);
Route::post('forgot-password', ForgotPasswordController::class);
Route::post('verification-otp', VerificationOtp::class);
Route::post('reset-password', ResetPasswordController::class);
Route::middleware(['api', 'auth:sanctum'])->group(function () {
    Route::post('logout', LogoutController::class);
});
