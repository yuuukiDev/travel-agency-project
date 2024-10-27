<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TravelController extends Controller
{
    //
    use APIResponder;

    public function store(CreateTravelRequest $request): JsonResponse
    {
        $travel = Travel::create($request->validated());

        return $this->successResponse(new TravelResource($travel), 'Travel Created Successfully!!');
    }

    public function update(Travel $travel, CreateTravelRequest $request): JsonResponse
    {
        $travel->update($request->validated());

        if (isset($travel->name)) {
            $travel->slug = Str::slug($travel->name);
        }

        $travel->save();

        return $this->successResponse(new TravelResource($travel), 'Travel Updated Successfully!!');
    }

    public function destroy(Travel $travel): JsonResponse
    {
        $travel->delete();

        return $this->successResponse($travel, 'Travel deleted successfully!');
    }
}
