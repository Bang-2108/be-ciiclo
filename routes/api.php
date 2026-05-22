<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Api\Client\ProfileController as PublicProfileController;
use App\Http\Controllers\Api\Client\SkillController as PublicSkillController;
    
Route::prefix('v1')->group(function () {
    Route::prefix('public')->group(function () {
        Route::get('/profile', [PublicProfileController::class, 'index']);
        Route::get('/skills', [PublicSkillController::class, 'index']);
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
    });
});