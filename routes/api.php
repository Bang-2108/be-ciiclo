<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Api\SkillController as PublicSkillController; 
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;

Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/skills', [PublicSkillController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/skills', [AdminSkillController::class, 'index']);      
    Route::post('/skills', [AdminSkillController::class, 'store']);    
    Route::put('/skills/{id}', [AdminSkillController::class, 'update']);
    Route::delete('/skills/{id}', [AdminSkillController::class, 'destroy']);

    Route::get('/profile', [AdminProfileController::class, 'show']);
    Route::post('/profile', [AdminProfileController::class, 'update']);
});