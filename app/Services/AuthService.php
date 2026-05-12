<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService extends BaseService
{
    public function __construct(UserRepository $userRepo)
    {
        parent::__construct($userRepo);
    }

    public function register(array $data)
    {
        try {
            $data['password'] = Hash::make(
                $data['password']
            );

            unset($data['password_confirmation']);

            return $this->repository->create($data);
        } catch (\Exception $e) {
            Log::error(
                'Register Error: ' .
                    $e->getMessage()
            );

            throw new \Exception(
                'Không thể tạo tài khoản, vui lòng thử lại sau.'
            );
        }
    }

    public function login(array $data)
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
        } catch (\Exception $e) {
            Log::error(
                'Login Error: ' .
                    $e->getMessage()
            );

            throw new \Exception(
                'Có lỗi hệ thống xảy ra trong quá trình đăng nhập.'
            );
        }
    }
}
