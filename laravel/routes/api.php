<?php

use Illuminate\Support\Facades\Route;
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/filters', [\App\Http\Controllers\NewsController::class, 'getFilters']);
Route::get('/news', [\App\Http\Controllers\NewsController::class, 'allNews']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/preferences', [\App\Http\Controllers\AuthController::class, 'getPreferences']);
    Route::post('/preferences', [\App\Http\Controllers\AuthController::class, 'savePreferences']);
});

