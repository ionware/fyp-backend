<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    /**
     * Authentication routes.
     */
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'create'])->name('auth.login');
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Session resource
        Route::apiResource('session', SessionController::class);
    });

});
