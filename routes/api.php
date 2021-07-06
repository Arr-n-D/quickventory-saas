<?php

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

Route::middleware(['throttle:25,1', 'auth:api'])->prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->withoutMiddleware('auth:api');
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
    Route::post('/refreshMe', [AuthController::class, 'refresh'])->withoutMiddleware('auth:api');
    Route::get('/me', [AuthController::class, 'me']);
});