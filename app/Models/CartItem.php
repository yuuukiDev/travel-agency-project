<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class CartItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'cart_id',
        'tour_id',
        'qty',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function getTotalAttribute()
    {
        return $this->qty * $this->tour->price;
    }
}
