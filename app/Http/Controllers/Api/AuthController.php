<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register(
                $request->validated()
            );

            return $this->success(
                $user,
                'Đăng ký tài khoản thành công!',
                201
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                500
            );
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login(
                $request->validated()
            );

            if ($result['status'] === 'email_not_found') {
                return $this->error(
                    'Email không tồn tại.',
                    404
                );
            }

            if ($result['status'] === 'password_incorrect') {
                return $this->error(
                    'Mật khẩu sai.',
                    401
                );
            }

            return $this->success(
                [
                    'token' => $result['token'],
                    'user'  => $result['user'],
                ],
                'Đăng nhập thành công!'
            );
        } catch (\Exception $e) {
            return $this->error(
                $e->getMessage(),
                500
            );
        }
    }
}
