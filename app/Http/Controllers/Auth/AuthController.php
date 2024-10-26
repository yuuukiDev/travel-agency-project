<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordValidationRequest;
use App\Http\Requests\VerifyRequest;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;
use App\Services\AuthService;

class AuthController extends Controller
{
    use APIResponder;

    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(CreateUserRequest $request) : JsonResponse
    {
        
        $user = $this->authService->register($request->validated());
        
        return $this->successResponse($user, "User has been registered waiting for verification....");
    }
    public function verify(VerifyRequest $request): JsonResponse
    {

        $user = $this->authService->verify($request->validated());

        return $this->successResponse($user, "User has been verified you can login now!");
    }

    public function login(LoginRequest $request)
    {

        $user = $this->authService->login($request->validated());
         
        return $this->successResponse($user, "User has been logged in successfully");
    }
    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {

         $user = $this->authService->forgetPassword($request->validated());

        return $this->successResponse($user, "OTP sent successfully!");
    }

    public function checkVerificationCode(VerifyRequest $request): JsonResponse
    {
       
        $user = $this->authService->checkOTP($request->validated());

        return $this->successResponse($user, "You can reset your password now!");
    }
    public function resetPassword(PasswordValidationRequest $request): JsonResponse
    {

        $user = $this->authService->resetPassword($request->validated());

        return $this->successResponse($user, "Password has been updated");
    }

    public function logout(): JsonResponse
    {

        $user = $this->authService->logout();

        return $this->successResponse($user, "you logged out successfully!");

    }
}