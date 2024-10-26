<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

class TourController extends Controller
{
    use APIResponder;
    //
    public function createTour(CreateTourRequest $request, Travel $travel): JsonResponse
    {
        $tour = Tour::create(array_merge($request->validated(), ['travel_id' => $travel->id]));
        
        return $this->successResponse(new TourResource($tour), "Tour Created Successfully!!");   
    }

    public function updateTour(Travel $travel, CreateTourRequest $request): JsonResponse
    {
        $travel->tours()->update($request->validated());

        return $this->successResponse(new TourResource($travel), "Tour Updated Successfully!!");    
    }


    public function deleteTour(Travel $travel): JsonResponse
    {
        $travel->tours()->delete();

        return $this->successResponse($travel, "Tour deleted successfully");
    }

}
