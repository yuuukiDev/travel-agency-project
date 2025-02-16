<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Auth\RegisterDTO;
use App\Enums\UserStatus;
use App\Events\UserVerificationRequested;
use App\Exceptions\PasswordException;
use App\Exceptions\UserStatusException;
use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly TokenManager $tokenManager
    ){}
    public function register(RegisterDTO $dto): array
    {
        $user = $this->authRepository->create($dto->toArray());

        event(new UserVerificationRequested($user));

        return [
            'user' => $user,
            'token' => $this->tokenManager->generateAccessToken($user),
        ];
    }

    public function verify(array $data): array
    {
        $user = $this->authRepository->findUserByEmailAndOTP($data['email'], $data['code']);

        $user->update([
            'is_active' => UserStatus::ACTIVE->value,
            'verification_code' => null,
        ]);

        return $this->tokenManager->respondWithUserAndToken($user);
    }

    public function login($data)
    {
        return $this->tokenManager->respondWithUserAndToken(
            $this->validateUserCredentials(
                $data
            ));
    }
    public function logout($user)
    {
        return $this->tokenManager->deleteAccessTokens($user);
    }
    private function validateUserCredentials($data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        if (! Hash::check($data['password'], $user->password)) {
            throw PasswordException::incorrect();
        }

        $this->ensureUserIsActive($user);

        return $user;
    }
    private function ensureUserIsActive(User $user)
    {
        if ($user->is_active !== UserStatus::ACTIVE->value) {
            throw UserStatusException::notActiveOrBlocked();
        }
    }


    public function forgetPassword(array $data): User
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        event(new UserVerificationRequested($user));

        return $user;
    }

    public function checkOTP($data)
    {
        return $this->tokenManager->respondWithUserAndToken(
            $this->authRepository->findUserByEmailAndOTP(
                $data['email'], $data['code'])
        );
    }
    public function resetPassword($data, $user)
    {

        if (Hash::check($data['password'], $user->password)) {
            throw PasswordException::sameAsCurrent();
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        $this->tokenManager->deleteAccessTokens($user);

        $user->notify(new PasswordChangedNotification(config('app.admin_email')));

        return $user;
    }
}
