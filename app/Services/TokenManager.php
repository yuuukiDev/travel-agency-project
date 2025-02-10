<?php


declare(strict_types=1);

namespace App\Services;

use App\Models\User;

final class TokenManager
{
    public function createToken(User $user): string
    {
        return $user->createToken('Personal Access Token')->plainTextToken;
    }
}
