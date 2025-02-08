<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Travel;
use App\Observers\TravelObserver;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Travel::observe(TravelObserver::class);
    }
}
