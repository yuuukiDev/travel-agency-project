<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ToursListRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use App\Services\TourService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class TourController extends Controller
{
    use APIResponder;

    /**
     * Display a listing of the resource.
     */
    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }

    public function index(Travel $travel, ToursListRequest $request): JsonResponse
    {
        $tours = $this->tourService->filterTours($travel, $request);

        return $this->successResponse(
            TourResource::collection(
                $tours),
            'Tours has been filtered'
        );

    }
}
