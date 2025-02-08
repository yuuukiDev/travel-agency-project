<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;
    case ACCEPTED = 1;
    case CANCELED = 2;
}
