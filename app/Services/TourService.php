<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\TourDTO;
use App\Models\Tour;
use App\Repositories\TourRepository;
use App\Repositories\TravelRepository;

final class TourService
{
    public function __construct(
        private readonly TravelRepository $travelRepository,
        private readonly TourRepository $tourRepository
    ) {}

    public function create(string $slug, TourDTO $dto): Tour
    {
        $travel = $this->travelRepository->getTravelBySlug($slug);

        return $this->tourRepository->create($travel, $dto->toArray());
    }

    public function update(string $travelSlug, string $tourSlug, array $data): Tour
    {
        $tour = $this->tourRepository->getTravelAndTourBySlug($travelSlug, $tourSlug);
        $tour->update($data);

        return $tour;
    }

    public function delete(string $travelSlug, string $tourSlug): void
    {
        $tour = $this->tourRepository->getTravelAndTourBySlug($travelSlug, $tourSlug);

        $tour->delete();
    }
}
