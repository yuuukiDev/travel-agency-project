<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourImageRequest;
use App\Models\Tour;
use App\Services\TourImageService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourImageController extends Controller
{
    use APIResponder;

    private TourImageService $tourImageService;

    public function __construct(TourImageService $tourImageService)
    {
        $this->tourImageService = $tourImageService;
    }

    public function store(TourImageRequest $request, Tour $tour): JsonResponse
    {
        return $this->successResponse($this->tourImageService->upload($request->validated(), $tour->id), 'Tour image uploaded successfully!');
    }

    public function update(TourImageRequest $request, $tour_id, $tour_image_id)
    {
        return $this->successResponse($this->tourImageService->update($tour_id, $tour_image_id, $request->validated()), 'Tour image updated successfully!');
    }

    public function destroy(Request $request): JsonResponse
    {
        return $this->successResponse($this->tourImageService->delete($tourId), 'Image deleted successfully from the tour');
    }
}
