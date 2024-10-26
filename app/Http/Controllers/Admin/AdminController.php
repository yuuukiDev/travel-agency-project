<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTourRequest;
use App\Http\Requests\CreateTravelRequest;
use App\Http\Resources\TourResource;
use App\Http\Resources\TravelResource;
use App\Models\Tour;
use App\Models\Travel;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
class AdminController extends Controller
{
    //
    use APIResponder;

    public function createTravel(CreateTravelRequest $request): JsonResponse
    {
        $travel = Travel::create($request->validated());

        return $this->successResponse(new TravelResource($travel), "Travel Created Successfully!!");   
    }

    public function createTour(CreateTourRequest $request, Travel $travel): JsonResponse
    {
        $tour = Tour::create(array_merge($request->validated(), ['travel_id' => $travel->id]));
        
        
        return $this->successResponse(new TourResource($tour), "Tour Created Successfully!!");   

    }

    public function updateTravel(Travel $travel, CreateTravelRequest $request): JsonResponse
    {
        $travel->update($request->validated());

        if (isset($travel->name)) {
            $travel->slug = Str::slug($travel->name);
        }

        $travel->save();

        return $this->successResponse(new TravelResource($travel), "Travel Updated Successfully!!");    
    }
    public function updateTour(Travel $travel, CreateTourRequest $request): JsonResponse
    {
        $travel->tours()->update($request->validated());

        return $this->successResponse(new TourResource($travel), "Tour Updated Successfully!!");    
    }

    public function deleteTravel(Travel $travel): JsonResponse
    {
        $travel->delete();

        return $this->successResponse($travel, "Travel deleted successfully!");
    }
    public function deleteTour(Travel $travel): JsonResponse
    {
        $travel->tours()->delete();

        return $this->successResponse($travel, "Tour deleted successfully");
    }
}