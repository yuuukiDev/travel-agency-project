<?php


declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Travel;

interface TravelInterface
{
    public function create(array $data): Travel;

    public function getTravelBySlug(string $slug): Travel;
}
