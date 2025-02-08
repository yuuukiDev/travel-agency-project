<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Travel;
use Illuminate\Support\Str;

final class TravelObserver
{
    //

    public function creating(Travel $travel)
    {
        $travel->slug = Str::slug($travel->name);
    }
}
