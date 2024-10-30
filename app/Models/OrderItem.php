<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    //
    use SoftDeletes, HasUuids;

    protected $fillable = [
        "order_id",
        "tour_id",
        "tour_name",
        "tour_image",
        "qty",
        "price",
        "sub_total"
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

}
