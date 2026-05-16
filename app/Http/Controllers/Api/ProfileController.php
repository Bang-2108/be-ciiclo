<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __construct(protected ProfileService $profileService) {}

    public function index(): JsonResponse
    {
        return $this->success(
            $this->profileService->getProfile(),
             "Profile information retrieved successfully"
        );
    }
}