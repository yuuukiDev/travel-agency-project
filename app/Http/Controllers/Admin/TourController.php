<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\TourDTO;
use App\Enums\Messages\TourActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTourRequest;
use App\Http\Requests\UpdateTourRequest;
use App\Http\Resources\TourResource;
use App\Services\TourService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class TourController extends Controller
{
    use APIResponder;

    public function __construct(
        private readonly TourService $tourService
    ){}

    public function store(CreateTourRequest $request, string $slug): JsonResponse
    {
        return $this->successResponse(
            new TourResource(
                $this->tourService->create(
                    $slug, TourDTO::fromArray(
                        $request->validated()
                    )
                )
            ),
            TourActions::CREATED->value
        );
    }
        public function update(string $travelSlug, string $tourSlug, UpdateTourRequest $request): JsonResponse
        {
            return $this->successResponse(
                new TourResource(
                    $this->tourService->update(
                        $travelSlug, $tourSlug, $request->validated()
                    )
                ),
                TourActions::UPDATED->value
            );
        }

    public function destroy(string $travelSlug, string $tourSlug): JsonResponse
    {
        return $this->successResponse(
            $this->tourService->delete(
                $travelSlug, $tourSlug
            ),
            TourActions::DELETED->value
        );
    }
}
