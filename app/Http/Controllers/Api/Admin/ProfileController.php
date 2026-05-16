<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService) {}
    public function show(): JsonResponse
    {
        return $this->success($this->profileService->getProfile());
    }
    public function update(ProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->updateProfile($request->validated());
        return $this->success($profile, "Profile updated successfully");
    }
}