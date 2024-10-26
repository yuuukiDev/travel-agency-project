<?php

namespace App\Exceptions;

use Exception;

class UserStatusException extends Exception
{
    /**
     * Create a new class instance.
     */
    public static function notActiveOrBlocked(): self
    {
        // return (new self)->failedResponse("User is not active or blocked");
        return new self('User is not active or blocked');
    }
}
