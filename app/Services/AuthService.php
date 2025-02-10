<?php

declare(strict_types=1);

namespace App\Services;

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
    public function register(array $data): array
    {
        $user = $this->authRepository->create($data);

        event(new UserVerificationRequested($user));

        return [
            'user' => $user,
            'token' => $this->tokenManager->createToken($user),
        ];
    }

    public function verify($data)
    {
        $user = $this->findUserByEmailAndOTP($data);

        $user->update([
            'is_active' => UserStatus::ACTIVE->value,
            'verification_code' => null,
        ]);

        return $this->respondWithUserAndToken($user);
    }

    public function login($data)
    {
        return $this->respondWithUserAndToken(
            $this->validateUserCredentials(
                $data
            ));
    }

    public function forgetPassword($data)
    {
        $user = $this->findUserByEmail($data['email']);

        event(new UserVerificationRequested($user));

        return $user;
    }

    public function checkOTP($data)
    {
        return $this->respondWithUserAndToken(
            $this->findUserByEmailAndOTP(
                $data)
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

        $this->deleteAccessTokens($user);

        $user->notify(new PasswordChangedNotification(config('app.admin_email')));

        return $user;
    }

    public function logout($user)
    {
        return $this->deleteAccessTokens($user);
    }

    /**
     * Create a new class instance.
     */
    private function generateAccessToken(User $user)
    {
        return $user->createToken('Personal Access Token')->plainTextToken;
    }

    private function deleteAccessTokens(User $user)
    {
        $user->tokens()->delete();
    }

    private function findUserByEmail($email)
    {
        return User::whereEmail($email)->firstOrFail();
    }

    private function validateUserCredentials($data)
    {
        $user = $this->findUserByEmail($data['email']);

        if (! Hash::check($data['password'], $user->password)) {
            throw PasswordException::incorrect();
        }

        $this->ensureUserIsActive($user);

        return $user;
    }

    private function findUserByEmailAndOTP($data)
    {
        return $this->findUserByEmail($data['email'])
            ->whereVerificationCode($data['code'])
            ->firstOrFail();
    }

    private function ensureUserIsActive(User $user)
    {
        if ($user->is_active !== UserStatus::ACTIVE->value) {
            throw UserStatusException::notActiveOrBlocked();
        }
    }

    private function respondWithUserAndToken(User $user)
    {
        return [
            'user' => $user,
            'access_token' => $this->generateAccessToken($user),
        ];
    }
}
