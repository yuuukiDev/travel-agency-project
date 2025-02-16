<?php

declare(strict_types=1);

namespace App\Enums\Messages;

enum AuthMessages: string
{
    case REGISTERED = 'User Registered, Waiting for verification.';
    case VERIFIED = 'User verified. You can now log in.';

    case LOGGED_IN = 'Login successful';
    case LOGGED_OUT = 'Logged out successfully.';
}
