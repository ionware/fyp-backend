<?php

use App\Http\Controllers\ThirdPartyController;
use Illuminate\Support\Facades\Route;

Route::middleware('pktum')->group(function () {
    Route::get('/students', [ThirdPartyController::class, 'students']);
    Route::get('/sessions', [ThirdPartyController::class, 'session']);
    Route::get('/lecturers', [ThirdPartyController::class, 'lecturers']);
});
