<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class OrderController extends Controller
{
    use APIResponder;

    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Confirm an order from the cart.
     */
    public function confirm(int $cartId): JsonResponse
    {
        return $this->successResponse(
            $this->orderService->confirm(
                $cartId, auth()->id()),
            'Order Confirmed'
        );
    }

    /**
     * Accept an order by ID.
     */
    public function accept(int $orderId): JsonResponse
    {
        return $this->successResponse(
            $this->orderService->accept(
                $orderId),
            'Order Accepted'
        );
    }
}
