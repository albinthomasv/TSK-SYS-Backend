<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::prefix('v1')->group(function () {
    Route::post('/user/login', [UserController::class, 'login']);
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/user/logout', [UserController::class, 'logout']);
        Route::apiResource('tasks', TaskController::class)->parameters([
            'tasks' => 'task:slug'
        ]);;

    });

});