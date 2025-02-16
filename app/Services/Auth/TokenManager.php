<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;

final class TokenManager
{
    public function generateAccessToken(User $user): string
    {
        return $user->createToken('Personal Access Token')->plainTextToken;
    }

    public function respondWithUserAndToken(User $user): array
    {
        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user),
        ];
    }

    public function deleteAccessTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
