<?php

namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;
use App\Classes\BaseService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    )
    {
    }

    /**
     * Register a new user
     */
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = UserRole::USER;
        
        return $this->userRepository->save($data);
    }

    /**
     * Find user by email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->firstWhere(['email' => $email]);
    }

    /**
     * Verify user credentials
     */
    public function verifyCredentials(string $email, string $password): bool
    {
        $user = $this->findByEmail($email);
        
        if (!$user) {
            return false;
        }
        
        return Hash::check($password, $user->password);
    }

    /**
     * Get user by email
     */
    public function getUserByEmail(string $email): ?User
    {
        return $this->findByEmail($email);
    }
}