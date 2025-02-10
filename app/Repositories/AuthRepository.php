<?php


declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

final class AuthRepository
{

    public function create(array $data): User
    {
        return User::create($data);
    }
    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}
