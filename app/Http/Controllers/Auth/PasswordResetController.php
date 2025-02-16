<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\Messages\AuthMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\PasswordValidationRequest;
use App\Services\Auth\PasswordResetService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class PasswordResetController extends Controller
{
    use APIResponder;

    public function __construct(
        private readonly PasswordResetService $passwordResetService,
    ) {}

    public function forgetPassword(ForgetPasswordRequest $request): JsonResponse
    {

        return $this->successResponse(
            $this->passwordResetService->forgetPassword(
                $request->validated()),
            AuthMessages::FORGOT_PASSWORD->value
        );
    }

    public function resetPassword(PasswordValidationRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->passwordResetService->resetPassword(
                $request->validated(),
                auth()->user()),
            AuthMessages::RESET_PASSWORD->value
        );
    }
}
