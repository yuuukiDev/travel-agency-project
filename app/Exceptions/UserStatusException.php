<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class UserStatusException extends Exception
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
