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
        $result = $this->authService->login($request->validated());
        return match ($result['status']) {
            'failed' => $this->error('Invalid email or password.', 401),
            default => $this->success([
                'token' => $result['token'],
                'user' => $result['user'],
            ], 'Login successful!')
        };
    }
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()?->currentAccessToken();
        if ($token) {
            $token->delete();
        }
        return $this->success(null, 'Logout successful!');
    }
}