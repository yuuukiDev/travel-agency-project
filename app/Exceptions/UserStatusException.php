<?php

namespace App\Exceptions;

use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

class UserStatusException
{
    use APIResponder;
    /**
     * Create a new class instance.
     */
    public static function notActiveOrBlocked(): JsonResponse
    {
        return (new self)->failedResponse("User is not active or blocked");
    }
}