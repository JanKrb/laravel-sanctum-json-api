<?php

use App\Http\Controllers\Security\AuthController;
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

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login'])
        ->withoutMiddleware('auth:sanctum')
        ->name('login');

    Route::post('register', [AuthController::class, 'register'])
        ->withoutMiddleware('auth:sanctum')
        ->name('register');

    Route::get('user', [AuthController::class, 'user'])
        ->name('user');
});
