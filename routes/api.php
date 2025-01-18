<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware('api-midleware');
    Route::post('register', [AuthController::class, 'register'])->middleware('api-midleware');
});

Route::middleware(['auth:sanctum', 'api-midleware'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('user', [UserController::class, 'index']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});
