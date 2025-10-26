<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public admin routes
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected admin routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // User management
    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Task management
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

     // Reports
    Route::prefix('reports')->group(function () {
        Route::get('/tasks', [ReportController::class, 'completedTasks']); // Bonus task
    });
});
