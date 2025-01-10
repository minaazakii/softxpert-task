<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Auth\AuthController;

Route::prefix('auth')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });


Route::apiResource('/tasks', TaskController::class)->middleware('auth:sanctum');
Route::middleware('auth:sanctum')
    ->prefix('tasks')
    ->group(function () {
        Route::put('/{task}/status', [TaskController::class, 'updateStatus']);
        Route::put('/{task}/assign-user', [TaskController::class, 'assignUserToTask']);
    });
