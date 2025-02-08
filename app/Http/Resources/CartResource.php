<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => auth()->user()->name,
            'items' => $this->items->map(function ($item) {
                $tour = $item->tour;

                return [
                    'travel_name' => $tour->travel->name,
                    'tour_name' => $tour->name,
                    'price' => $tour->price,
                    'qty' => $item->qty,
                    'total_price' => $item->total,
                ];
            }),
        ];
    }
}
