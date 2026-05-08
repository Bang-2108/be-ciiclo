<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    public function __construct(UserRepository $userRepo)
    {
        parent::__construct($userRepo);
    }
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        return $this->repository->create($data);
    }
    public function login(array $data)
    {
        $user = $this->repository->findByEmail($data['email']);
        if (!$user) return ['status' => 'email_not_found'];
        if (!Hash::check($data['password'], $user->password)) {
            return ['status' => 'password_incorrect'];
        }

        return [
            'status' => 'success',
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }
}