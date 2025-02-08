<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Role extends Model
{
    //
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
