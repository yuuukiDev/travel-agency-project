<?php

namespace App\Utils;

use App\Enums\ApiResponse;
use Illuminate\Http\JsonResponse;

trait APIResponder
{
    /**
     * trait used for implementing custom API Responses
     */
    public function successResponse($data = [], $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => ApiResponse::SUCCESS_STATUS->value,
            'message' => $message ?? ApiResponse::SUCCESS_MESSAGE->value,
            'data' => $data,
        ], $code);
    }

    public function failedResponse($message = null, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => ApiResponse::FAILED_STATUS->value,
            'message' => $message ?? APIResponse::FAILED_MESSAGE->value,
        ], $code);
    }
}
