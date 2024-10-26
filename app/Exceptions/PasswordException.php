<?php

namespace App\Exceptions;

use Exception;

class PasswordException extends Exception
{
    /**
     * Create a new class instance.
     */
    public static function incorrect(): self
    {
        return new self('Password is incorrect');
    }

    public static function sameAsCurrent(): self
    {
        return new self('New password cannot be the same as the current password!');
    }
}
