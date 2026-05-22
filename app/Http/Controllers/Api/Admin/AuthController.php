<?php

namespace App\Http\Controllers\Api\Admin;

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
                    'Email does not exist.',
                    404
                ),
                'password_incorrect' => $this->error(
                    'Incorrect password.',
                    401
                ),
                default => $this->success(
                    [
                        'token' => $result['token'],
                        'user'  => $result['user'],
                    ],
                    'Login successful!'
                )
            };
        } catch (\Throwable $e) {
            return $this->error(
                'An error occurred during login.',
                500
            );
        }
    }
    public function logout(Request $request): JsonResponse
    {
        try {

            $token = $request->user()?->currentAccessToken();

            if ($token) {
                $token->delete();
            }
            return $this->success(
                null,
                'Logout successful!'
            );
        } catch (\Throwable $e) {

            return $this->error(
                'An error occurred during logout.',
                500
            );
        }
    }
}
