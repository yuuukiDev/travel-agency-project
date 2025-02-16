<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class UserProfile extends Model
{
    use SoftDeletes;
    //

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'avatar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
