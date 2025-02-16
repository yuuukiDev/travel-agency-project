<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Enums\UserStatus;
use App\Repositories\AuthRepository;

final class VerificationService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly TokenManager $tokenManager
    ){}
    public function verify(array $data): array
    {
        $user = $this->authRepository->findUserByEmailAndOTP($data['email'], $data['code']);

        $user->update([
            'is_active' => UserStatus::ACTIVE->value,
            'verification_code' => null,
        ]);
        
        return $this->tokenManager->respondWithUserAndToken($user);
    }
}
