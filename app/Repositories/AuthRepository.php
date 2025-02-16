<?php


declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;

final class AuthRepository implements AuthInterface
{

    public function create(array $data): User
    {
        return User::create($data);
    }
    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
    public function findUserByEmailAndOTP(string $email, string $code): User
    {
        return $this->getUserByEmail($email)
            ->whereVerificationCode($code)
            ->firstOrFail();
    }
}
