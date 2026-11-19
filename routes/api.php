<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Rate limiter didefinisikan di AppServiceProvider::configureRateLimiting()
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:api-register');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:api-login');

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
