<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsahaController;
use App\Http\Controllers\AdminController;
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
    Route::put('/usaha/{id}/verify', [UsahaController::class, 'verify']);
    Route::get('/usaha-creators', [UsahaController::class, 'creators']);

    // Admin — user management
    Route::get('/admin/users', [AdminController::class, 'index']);
    Route::post('/admin/users', [AdminController::class, 'store']);
    Route::put('/admin/users/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy']);
});
