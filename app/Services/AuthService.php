<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthService extends BaseService
{
    public function __construct(UserRepository $userRepo)
    {
        parent::__construct($userRepo);
    }

    public function login(array $data): array
    {
        try {
            $user = $this->repository->findByEmail(
                $data['email']
            );

            if (!$user) {
                return [
                    'status' => 'email_not_found',
                ];
            }

            if (
                !Hash::check(
                    $data['password'],
                    $user->password
                )
            ) {
                return [
                    'status' => 'password_incorrect',
                ];
            }

            return [
                'status' => 'success',

                'token' => $user
                    ->createToken('auth_token')
                    ->plainTextToken,

                'user' => $user,
            ];

        } catch (Throwable $e) {

            Log::error('Login Error', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            throw $e;
        }
    }
}