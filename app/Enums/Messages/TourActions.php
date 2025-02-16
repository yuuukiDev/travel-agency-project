<?php

declare(strict_types=1);

namespace App\Enums\Messages;

enum TourActions: string
{
    case CREATED = 'Tour created successfully';
    case UPDATED = 'Tour updated successfully';
    case DELETED = 'Tour deleted successfully';

}
