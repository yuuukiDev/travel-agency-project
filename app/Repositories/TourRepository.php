<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\TourInterface;
use App\Models\Tour;
use App\Models\TourImage;
use App\Models\Travel;

final class TourRepository implements TourInterface
{
    public function __construct(
        private readonly TravelRepository $travelRepository
    ) {}

    public function create(Travel $travel, array $data): Tour
    {
        return $travel->tours()->create($data);
    }

    public function getTourBySlug(string $slug): Tour
    {
        return Tour::where('slug', $slug)->firstOrFail();
    }

    public function getTravelAndTourBySlug(string $travelSlug, string $tourSlug): Tour
    {
        $this->travelRepository->getTravelBySlug($travelSlug);

        return $this->getTourBySlug($tourSlug);
    }
    public function createImages(Tour $tour, array $paths): void
    {
        $tour->images()->createMany(
            array_map(fn ($path) => ['path' => $path], $paths)
        );
    }

    public function getImagesByTour(Tour $tour): array
    {
        return $tour->images()->get()->all();
    }

}
