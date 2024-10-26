<?php

namespace App\Exceptions;

use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

class PasswordException
{
    use APIResponder;
    /**
     * Create a new class instance.
     */

     public static function incorrect(): JsonResponse
     {
        return (new self)->failedResponse("Password is incorrect");
     }

     public static function sameAsCurrent(): JsonResponse
     {
        return (new self)->failedResponse("New password cannot be the same as the current password!");
     }
}