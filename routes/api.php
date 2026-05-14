<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Api\SkillController as PublicSkillController; // Sửa namespace nếu cần

// Public Routes
Route::get('/profile', [ProfileController::class, 'index']);
Route::get('/skills', [PublicSkillController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);

// Admin Routes - Thêm prefix 'admin' ở đây
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/skills', [AdminSkillController::class, 'index']);      // GET /api/admin/skills
    Route::post('/skills', [AdminSkillController::class, 'store']);    // POST /api/admin/skills
    Route::put('/skills/{id}', [AdminSkillController::class, 'update']);
    Route::delete('/skills/{id}', [AdminSkillController::class, 'destroy']);
});