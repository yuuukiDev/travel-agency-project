<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Enums\Messages\AuthMessages;
use App\Events\UserVerificationRequested;
use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use App\Repositories\AuthRepository;
use App\Utils\APIResponder;
use Illuminate\Support\Facades\Hash;

final class PasswordResetService
{
    use APIResponder;

    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly TokenManager $tokenManager,
        private readonly AuthService $authService,

    ) {}

    public function forgetPassword(array $data): array
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        $this->authService->ensureUserIsActive($user);

        event(new UserVerificationRequested($user));

        return $this->tokenManager->respondWithUserAndToken($user);
    }

    public function resetPassword(array $data, User $user): User
    {
        $this->isSameAsCurrentPassword($user, $data['password']);

        $user->update([
            'password' => Hash::make($data['password']),
            'verification_code' => null,
        ]);

        $this->tokenManager->deleteAccessTokens($user);

        $user->notify(new PasswordChangedNotification(config('app.admin_email')));

        return $user;
    }

    private function isSameAsCurrentPassword(User $user, string $password): void
    {
        if (Hash::check($password, $user->password)) {
            abort(400, AuthMessages::PASSWORD_CANNOT_BE_SAME_AS_OLD->value);
        }
    }
}
