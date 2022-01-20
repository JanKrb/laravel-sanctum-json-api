<?php

use App\Http\Controllers\Security\AuthController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth', 'as' => 'auth.'], function () {
    // Generic
    Route::get('user', [AuthController::class, 'user'])
        ->name('user');

    // Auth
    Route::post('login', [AuthController::class, 'login'])
        ->withoutMiddleware('auth:sanctum')
        ->name('login');

    Route::post('register', [AuthController::class, 'register'])
        ->withoutMiddleware('auth:sanctum')
        ->name('register');

    // E-Mail Verification

    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])
        ->withoutMiddleware('auth:sanctum')
        ->name('verification.verify');

    Route::post('email/resend', [VerificationController::class, 'resend'])
        ->name('verification.resend');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Roles
    Route::apiResource('roles', RoleController::class);
});
