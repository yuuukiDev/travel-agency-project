<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\TourImageInterface;
use App\Models\Tour;
use App\Models\TourImage;

final class TourImageRepository implements TourImageInterface
{
    public function createImages(Tour $tour, array $paths): void
    {
        $tour->images()->createMany(
            array_map(fn ($path): array => ['path' => $path], $paths)
        );
    }
    public function getImagesByTour(Tour $tour): array
    {
        return $tour->images()->get()->all();
    }

    public function getImageById(array $imageIds): TourImage 
    {
        return TourImage::where('id', $imageIds)->firstOrFail();
    }
}
