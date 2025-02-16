<?php


declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Tour;
use App\Models\Travel;

interface TourInterface
{
    public function create(Travel $travel, array $data): Tour;

    public function getTourBySlug(string $slug): Tour;

    public function getTravelAndTourBySlug(string $travelSlug, string $tourSlug): Tour;

}
