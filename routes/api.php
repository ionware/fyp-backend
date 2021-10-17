<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StatController;
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
        // Search controller
        Route::get('/search', [SearchController::class, 'index']);

        // Session resource
        Route::apiResource('session', SessionController::class);

        // Faculty resource
        Route::apiResource('faculty', FacultyController::class);

        // Department resource.
        Route::apiResource('department', DepartmentController::class);

        // Student resources
        Route::apiResource('student', StudentController::class);
        Route::get('/students', [StudentController::class, 'all']);

        // User resource (Lecturer & Admin module)
        Route::apiResource('user', UserController::class);

        Route::get('/me', [UserController::class, 'profile'])->name('profile');

        // API Key resource controller.
        Route::apiResource('key', ApiKeyController::class);

        Route::prefix('statistics')->group(function () {
            Route::get('/', [StatController::class, 'index']);
        });
    });

});
