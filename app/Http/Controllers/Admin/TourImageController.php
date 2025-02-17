<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\Messages\TourActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourImageRequest;
use App\Models\Tour;
use App\Services\TourImageService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class TourImageController extends Controller
{
    use APIResponder;
    
    public function __construct(
        private readonly TourImageService $tourImageService
    ){}

    public function store(TourImageRequest $request, string $slug): JsonResponse
    {
        return $this->successResponse(
            $this->tourImageService->handleImageOperations(
                 $slug,$request->file('images')
            ),
            TourActions::IMAGE_CREATED->value
        );
    }

    // public function update(TourImageRequest $request, Tour $tour, int $tour_image_id): JsonResponse
    // {

    //     return $this->successResponse(
    //         $this->tourImageService->upload(
    //              $slug,$request->validated()
    //         ),
    //         TourActions::IMAGE_UPDATED->value
    //     );
    // }

    // public function destroy(Tour $tour, int $tour_image_id): JsonResponse
    // {
    //     return $this->successResponse(
    //         $this->tourImageService->delete(['tour_image_id' => $tour_image_id], $tour->id),
    //         'Image deleted successfully from the tour'
    //     );
    // }
}
