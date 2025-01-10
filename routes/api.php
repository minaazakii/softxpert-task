<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\Auth\AuthController;

Route::prefix('auth')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login']);
    });


Route::middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('/tasks', TaskController::class);
    });
