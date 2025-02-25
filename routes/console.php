<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    if (User::where('verification_code', '!=', null)
        ->where('updated_at', '<', now()->subMinutes(5))
        ->exists()) {

        User::where('verification_code', '!=', null)
            ->where('updated_at', '<', now()->subMinutes(5))
            ->update(['verification_code' => null]);
    }
})->everyFiveMinutes();
