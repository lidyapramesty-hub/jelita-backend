<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsahaController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Usaha CRUD
    Route::get('/usaha/stats', [UsahaController::class, 'stats']);
    Route::get('/usaha', [UsahaController::class, 'index']);
    Route::post('/usaha', [UsahaController::class, 'store']);
    Route::get('/usaha/{id}', [UsahaController::class, 'show']);
    Route::put('/usaha/{id}', [UsahaController::class, 'update']);
    Route::delete('/usaha/{id}', [UsahaController::class, 'destroy']);
});
