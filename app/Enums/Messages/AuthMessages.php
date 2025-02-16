<?php

declare(strict_types=1);

namespace App\Enums\Messages;

enum AuthMessages: string
{
    case REGISTERED = 'User registered. Please verify your email with the code sent to you.';
    case VERIFIED = 'Verification successful. You can now proceed.';
    case LOGGED_IN = 'Login successful. Welcome back!';
    case LOGGED_OUT = 'You have been logged out successfully.';
    case FORGOT_PASSWORD = 'Verification code sent to your email address.';
    case RESET_PASSWORD = 'Your password has been successfully reset.';
    case INVALID_PASSWORD = 'The password provided does not match our records. Please check and try again.';
    case PASSWORD_CANNOT_BE_SAME_AS_OLD = 'The new password must be different from the current one.';
    case USER_INACTIVE_OR_BLOCKED = 'Your account is either inactive or blocked.';

}
