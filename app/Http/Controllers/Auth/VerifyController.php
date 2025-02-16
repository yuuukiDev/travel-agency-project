<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\Messages\AuthMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyRequest;
use App\Services\Auth\VerificationService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class VerifyController extends Controller
{
    use APIResponder;

    public function __construct(
        private readonly VerificationService $verificationService
    ){}
    public function __invoke(VerifyRequest $request): JsonResponse
    {
        return $this->successResponse(
            $this->verificationService->verify(
                $request->validated()),
                AuthMessages::VERIFIED->value
            );
    }
}
