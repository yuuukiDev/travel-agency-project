<?php

declare(strict_types=1);

namespace App\Enums\Messages;

enum TravelActions: string
{
    case CREATED = 'Travel created successfully';
    case UPDATED = 'Travel updated successfully';
    case DELETED = 'Travel deleted successfully';

}
