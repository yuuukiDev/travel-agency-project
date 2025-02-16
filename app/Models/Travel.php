<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Travel extends Model
{
    use HasUuids, Sluggable, SoftDeletes;
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

    public function getNumberOfNightsAttribute(): int
    {
        return $this->number_of_days - 1;
    }

    public function scopePublic(Builder $query): void
    {
        $query->where('is_public', true);
    }

    public function scopNotPublic(Builder $query): void
    {
        $query->where('is_public', false);
    }
}
