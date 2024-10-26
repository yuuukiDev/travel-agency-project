<?php

namespace App\Observers;

use App\Models\Travel;
use Illuminate\Support\Str;

class TravelObserver
{
    //

    public function creating(Travel $travel)
    {
        $travel->slug = Str::slug($travel->name);
    }
}
