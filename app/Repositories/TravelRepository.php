<?php


declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\TravelInterface;
use App\Models\Travel;

final class TravelRepository implements TravelInterface
{

    public function create(array $data): Travel
    {
        return Travel::create($data);
    }

    public function getTravelBySlug(string $slug): Travel
    {
        return Travel::where('slug', $slug)->firstOrFail();
    }
}
