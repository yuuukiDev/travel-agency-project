<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\TravelDTO;
use App\Models\Travel;
use App\Repositories\TravelRepository;

final class TravelService
{
    public function __construct(
        private readonly TravelRepository $travelRepository
    ) {}

    public function create(TravelDTO $dto): Travel
    {
        return $this->travelRepository->create($dto->toArray());
    }

    public function update(string $slug, array $data): Travel
    {
        $travel = $this->travelRepository->getTravelBySlug($slug);

        $travel->update($data);

        return $travel;
    }

    public function delete(string $slug): void
    {
        $travel = $this->travelRepository->getTravelBySlug($slug);

        $travel->delete();
    }
}
