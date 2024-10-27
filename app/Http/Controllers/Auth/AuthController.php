<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordValidationRequest;
use App\Http\Requests\VerifyRequest;
use App\Services\AuthService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use APIResponder;

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(CreateUserRequest $request): JsonResponse
    {

        return $this->successResponse($this->authService->register($request->validated()), 'User Registered, Waiting for verification.');
    }

    public function verify(VerifyRequest $request): JsonResponse
    {

        return $this->successResponse($this->authService->verify($request->validated()), 'User verified. You can now log in.');
    }

    public function login(LoginRequest $request)
    {
        return $this->successResponse($this->authService->login($request->validated()), 'Login successful.');
    }

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {

        return $this->successResponse($this->authService->forgetPassword($request->validated()), 'OTP sent successfully.');
    }

    public function checkVerificationCode(VerifyRequest $request): JsonResponse
    {
        return $this->successResponse($this->authService->checkOTP($request->validated()), 'OTP verified, you can reset your password now.');
    }

    public function resetPassword(PasswordValidationRequest $request): JsonResponse
    {
        return $this->successResponse($this->authService->resetPassword($request->validated(), auth()->user()), 'Password updated.');
    }

    public function logout(): JsonResponse
    {

        return $this->successResponse($this->authService->logout(auth()->user()), 'Logged out successfully.');

    }
}
