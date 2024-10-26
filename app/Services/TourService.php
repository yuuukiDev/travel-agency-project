<?php

namespace App\Services;

use App\Http\Requests\ToursListRequest;
use App\Models\Travel;

class TourService
{
    public function filterTours(Travel $travel, ToursListRequest $request)
    {
        $tours = $travel->tours();

        $filters = [
            'priceFrom' => function ($query, $value) {
                $query->where('price', '>=', $value * 100);
            },

            'priceTo' => function ($query, $value) {
                $query->where('price', '<=', $value * 100);
            },

            'dateFrom' => function ($query, $value) {
                $query->where('starting_date', '>=', $value);
            },

            'dateTo' => function ($query, $value) {
                $query->where('starting_date', '<=', $value);
            },
        ];

        foreach ($filters as $key => $filter) {
            if ($request->$key) {
                $filter($tours, $request->$key);
            }
        }
        $sortBy = $request->sortBy ?? 'starting_date';
        $sortOrder = $request->sortOrder ?? 'asc';
        $tours->orderBy($sortBy, $sortOrder);

        return $tours->paginate();
    }
}
