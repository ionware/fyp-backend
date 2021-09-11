<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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

        // Student resources
        Route::apiResource('student', StudentController::class);

        // User resource (Lecturer & Admin module)
        Route::apiResource('user', UserController::class);

        Route::get('/me', [UserController::class, 'profile'])->name('profile');
    });

});
