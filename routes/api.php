<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Api\Client\ProfileController as PublicProfileController;
use App\Http\Controllers\Api\Client\SkillController as PublicSkillController;
use App\Http\Controllers\Api\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\Client\ProjectController as PublicProjectController;

    

Route::prefix('v1')->group(function () {
    Route::prefix('public')->group(function () {
        Route::get('/profile', [PublicProfileController::class, 'index']);
        Route::get('/skills', [PublicSkillController::class, 'index']);
        Route::get('/projects', [PublicProjectController::class, 'index']);
    });

    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AdminProfileController::class, 'show']);
        Route::post('/profile', [AdminProfileController::class, 'update']);

        Route::get('/skills', [AdminSkillController::class, 'index']);      
        Route::post('/skills', [AdminSkillController::class, 'store']);    
        Route::put('/skills/{id}', [AdminSkillController::class, 'update']);
        Route::delete('/skills/{id}', [AdminSkillController::class, 'destroy']);

        Route::get('/projects', [AdminProjectController::class, 'index']);
        Route::post('/projects', [AdminProjectController::class, 'store']);
        Route::put('/projects/{id}', [AdminProjectController::class, 'update']);
        Route::delete('/projects/{id}', [AdminProjectController::class, 'destroy']);
    });
});