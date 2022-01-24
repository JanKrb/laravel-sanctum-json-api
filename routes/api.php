<?php

use App\Http\Controllers\Security\Auth\AuthController;
use App\Http\Controllers\Security\Auth\VerificationController;
use App\Http\Controllers\Security\Permissions\PermissionController;
use App\Http\Controllers\Security\Permissions\RoleController;
use App\Http\Controllers\Security\Permissions\RolePermissionsController;
use App\Http\Controllers\Security\Permissions\UserRolesController;
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
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);

    // Role Permission - Many to Many
    Route::get('roles/{role}/permissions', [RolePermissionsController::class, 'index']);
    Route::post('roles/{role}/permissions', [RolePermissionsController::class, 'show']);
    Route::get('roles/{role}/permissions/{permission}', [RolePermissionsController::class, 'show']);
    Route::delete('roles/{role}/permissions/{permission}', [RolePermissionsController::class, 'destroy']);

    // User Roles - Many to Many
    Route::get('users/{user}/roles', [UserRolesController::class, 'index']);
    Route::post('users/{user}/roles', [UserRolesController::class, 'show']);
    Route::get('users/{user}/roles/{role}', [UserRolesController::class, 'show']);
    Route::delete('users/{user}/roles/{role}', [UserRolesController::class, 'destroy']);

});
