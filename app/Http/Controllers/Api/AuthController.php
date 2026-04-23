<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller {
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    public function register(RegisterRequest $request) {
        $user = $this->authService->register($request->validated());
        return response()->json(['message' => 'Đăng ký thành công!', 'user' => $user], 201);
    }
    public function login(LoginRequest $request) {
        $result = $this->authService->login($request->validated());

        if ($result['status'] === 'email_not_found') 
            return response()->json(['message' => 'Email không tồn tại.'], 404);
        
        if ($result['status'] === 'password_incorrect') 
            return response()->json(['message' => 'Mật khẩu sai.'], 401);

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'token'   => $result['token'],
            'user'    => $result['user']
        ]);
    }
}