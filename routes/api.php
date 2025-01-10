<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;

Route::prefix('auth')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('users')
        ->group(function () {
            Route::get('tasks', [UserController::class, 'userTasks']);
        });

    Route::apiResource('/tasks', TaskController::class);
    Route::prefix('tasks')
        ->group(function () {
            Route::put('/{task}/status', [TaskController::class, 'updateStatus']);
            Route::put('/{task}/assign-user', [TaskController::class, 'assignUserToTask']);
            Route::post('/{task}/dependencies', [TaskController::class, 'addDependenciesToTask']);
        });

});

