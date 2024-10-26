<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

trait APIResponder
{
    /**
     * trait used for implementing custom API Responses
     */
    public function successResponse($data = [], $message = null, $code = 200): JsonResponse
    {
        return response()->json([
            'status' => Constants::$API_SUCCESS_STATUS,
            'message' => $message ?? Constants::$API_SUCCESS_MESSAGE,
            'data' => $data,
        ], $code);
    }

    public function failedResponse($message = null, $code = 400): JsonResponse
    {
        return response()->json([
            'status' => Constants::$API_FAILED_STATUS,
            'message' => $message ?? Constants::$API_FAILED_MESSAGE,
        ], $code);
    }
}
