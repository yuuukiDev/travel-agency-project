<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use HasUuids, SoftDeletes;
    //

    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'number_of_days',
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }

    public function getNumberOfNightsAttribute()
    {
        return $this->number_of_days - 1;
    }
}
