<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Tour;
use App\Models\TourImage;

interface TourImageInterface
{
    public function createImages(Tour $tour, array $paths): void;

    public function getImagesByTour(Tour $tour): array;

    public function getImageById(array $imageIds): TourImage;

}
