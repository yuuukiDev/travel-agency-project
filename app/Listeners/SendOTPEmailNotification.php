<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserVerificationRequested;
use App\Jobs\SendOTPEmail;

final class SendOTPEmailNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserVerificationRequested $event): void
    {
        //
        $code = random_int(1111, 9999);

        $event->user->update([
            'verification_code' => $code,
        ]);

        SendOTPEmail::dispatch(env(key: 'ADMIN_EMAIL'), $code);
    }
}
