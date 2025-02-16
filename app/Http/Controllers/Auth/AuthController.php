<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\RegisterDTO;
use App\Enums\Messages\AuthMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    use APIResponder;

    public function __construct(
        private readonly AuthService $authService,
    ){}
    public function register(CreateUserRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->authService->register(
                RegisterDTO::fromArray(
                    $request->validated()
                )
            ),
            AuthMessages::REGISTERED->value
        );
    }
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->authService->login(
                $request->validated()),
                AuthMessages::LOGGED_IN->value
            );
    }
    public function logout(): JsonResponse
    {

        return $this->successResponse(
            $this->authService->logout(
                auth()->user()),
                AuthMessages::LOGGED_OUT->value
            );
    }
}
