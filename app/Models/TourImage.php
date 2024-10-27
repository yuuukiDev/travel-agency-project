<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourImage extends Model
{
    use SoftDeletes, HasUuids;


    protected $fillable = [
        'tour_id',
        'image_path'
    ];


    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
