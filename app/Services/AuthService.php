<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService
{
    public function __construct(UserRepository $userRepo)
    {
        parent::__construct($userRepo);
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']); 
        return $this->repository->create($data);
    }

    public function login(array $data)
    {
        $user = $this->repository->findByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Thông tin đăng nhập không chính xác.'],
            ]);
        }
        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }
}
