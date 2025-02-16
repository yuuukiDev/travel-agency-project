<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\TravelDTO;
use App\Enums\Messages\TravelActions;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTravelRequest;
use App\Http\Requests\UpdateTravelRequest;
use App\Http\Resources\TravelResource;
use App\Services\TravelService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class TravelController extends Controller
{
    //
    use APIResponder;

    public function __construct(
        private readonly TravelService $travelService
    ) {}

    public function store(CreateTravelRequest $request): JsonResponse
    {
        return $this->successResponse(
            new TravelResource(
                $this->travelService->create(
                    TravelDTO::fromArray(
                        $request->validated()
                    )
                )
            ),
            TravelActions::CREATED->value
        );
    }

    public function update(UpdateTravelRequest $request, string $slug): JsonResponse
    {
        return $this->successResponse(
            new TravelResource(
                $this->travelService->update(
                    $slug,
                    $request->validated()
                )
            ), TravelActions::UPDATED->value
        );
    }

    public function destroy(string $slug): JsonResponse
    {
        return $this->successResponse(
            $this->travelService->delete($slug),
            TravelActions::DELETED->value
        );
    }
}
