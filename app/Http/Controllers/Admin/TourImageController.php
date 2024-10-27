<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourImageRequest;
use App\Http\Requests\UpdateTourImageRequest;
use App\Services\TourImageService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

class TourImageController extends Controller
{
    use APIResponder;

    private TourImageService $tourImageService;

    public function __construct(TourImageService $tourImageService)
    {
        $this->tourImageService = $tourImageService;
    }

    public function store(TourImageRequest $request): JsonResponse
    {
        return $this->successResponse($this->tourImageService->upload($request->validated()), 'Tour image uploaded successfully!');
    }

    public function update(UpdateTourImageRequest $request)
    {
        return $this->successResponse($this->tourImageService->update($request->validated()), 'Tour image updated successfully!');
    }

    public function destroy($id): JsonResponse
    {
        return $this->successResponse($this->tourImageService->delete($id), 'Image deleted successfully from the tour');
    }
}
