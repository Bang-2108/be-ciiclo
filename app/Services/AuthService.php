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
    public function login(array $data): array
    {
        $user = $this->repository->findByEmail($data['email']);
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'status' => 'failed',
            ];
        }
        return [
            'status' => 'success',
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ];
    }
}