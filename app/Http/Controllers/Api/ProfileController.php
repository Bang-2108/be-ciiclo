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
        try {
            $profile = $this->profileService->getProfile();
            if (!$profile) {
                return $this->error("Không tìm thấy thông tin cá nhân", 404);
            }
            return $this->success($profile, "Lấy profile thành công");
        } catch (\Exception $e) {
            return $this->error("Lỗi hệ thống", 500);
        }
    }
}
