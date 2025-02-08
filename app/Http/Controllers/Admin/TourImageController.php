<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourImageRequest;
use App\Models\Tour;
use App\Services\TourImageService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class TourImageController extends Controller
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

    public function update(TourImageRequest $request, Tour $tour, $tour_image_id)
    {

        return $this->successResponse(
            $this->tourImageService->update($request->validated(), $tour->id, $tour_image_id),
            'Tour image updated successfully!'
        );
    }

    public function destroy(Tour $tour, $tour_image_id): JsonResponse
    {
        return $this->successResponse(
            $this->tourImageService->delete(['tour_image_id' => $tour_image_id], $tour->id),
            'Image deleted successfully from the tour'
        );
    }
}
