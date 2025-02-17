<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTOs\Auth\RegisterDTO;
use App\Enums\Messages\AuthMessages;
use App\Enums\UserStatus;
use App\Events\UserVerificationRequested;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Utils\APIResponder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    use APIResponder;

    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly TokenManager $tokenManager,
    ) {}

    public function register(RegisterDTO $dto): array
    {
        $user = $this->authRepository->create($dto->toArray());

        event(new UserVerificationRequested($user));

        return $this->tokenManager->respondWithUserAndToken($user);
    }

    public function login(array $data): array
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        $this->ensureCredentialsIsValid($user, $data['password']);

        $this->ensureUserIsActive($user);

        return $this->tokenManager->respondWithUserAndToken($user);
    }

    public function logout(User $user): void
    {
        $this->tokenManager->deleteAccessTokens($user);
    }

    public function ensureUserIsActive(User $user): void
    {
        if ($user->is_active !== UserStatus::ACTIVE->value) {
            abort(Response::HTTP_BAD_REQUEST, AuthMessages::USER_INACTIVE_OR_BLOCKED->value);
        }
    }

    private function ensureCredentialsIsValid(User $user, string $password): void
    {
        if (! Hash::check($password, $user->password)) {
            abort(Response::HTTP_BAD_REQUEST, AuthMessages::INVALID_PASSWORD->value);
        }
    }
}
