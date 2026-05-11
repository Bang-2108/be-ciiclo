<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function index()
    {
        return response()->json([
            'success' => true,

            'data' => $this->profileService->getProfile()
        ]);
    }
}