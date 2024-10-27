<?php

namespace App\Services;

use App\Http\Requests\ToursListRequest;
use App\Models\Travel;

class TourService
{
    public function filterTours(Travel $travel, ToursListRequest $request)
    {
        $tours = $travel->tours();
    
        if ($request->priceFrom) {
            $tours->where('price', '>=', $request->priceFrom);
        }
    
        if ($request->priceTo) {
            $tours->where('price', '<=', $request->priceTo);
        }
    
        if ($request->dateFrom) {
            $tours->where('starting_date', '>=', $request->dateFrom);
        }
    
        if ($request->dateTo) {
            $tours->where('starting_date', '<=', $request->dateTo);
        }
    
        $sortBy = $request->sortBy ?? 'starting_date';
        $sortOrder = $request->sortOrder ?? 'asc';
        $tours->orderBy($sortBy, $sortOrder);
    
        return $tours->paginate();
    }
    
}
