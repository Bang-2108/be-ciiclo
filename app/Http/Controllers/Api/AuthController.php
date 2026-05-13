<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return match ($result['status']) {
                'email_not_found' => $this->error(
                    'Email không tồn tại.',
                    404
                ),
                'password_incorrect' => $this->error(
                    'Mật khẩu sai.',
                    401
                ),
                default => $this->success(
                    [
                        'token' => $result['token'],
                        'user'  => $result['user'],
                    ],
                    'Đăng nhập thành công!'
                )
            };
        } catch (\Throwable $e) {
            return $this->error(
                'Đã có lỗi xảy ra trong quá trình đăng nhập.',
                500
            );
        }
    }
    public function logout(Request $request): JsonResponse
    {
        try {
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
                return $this->success(null, 'Đăng xuất thành công!');
            }
            return $this->error('Không tìm thấy phiên làm việc hợp lệ.', 401);
        } catch (\Throwable $e) {
            return $this->error('Lỗi hệ thống khi đăng xuất.', 500);
        }
    }
}
