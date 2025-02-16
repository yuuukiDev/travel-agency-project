<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Tour extends Model
{
    use HasUuids, SoftDeletes, Sluggable;

    //
    protected $fillable = [
        'travel_id',
        'name',
        'slug',
        'starting_date',
        'ending_date',
        'price',
    ];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }

    public function tourImages(): HasMany
    {
        return $this->hasMany(TourImage::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
