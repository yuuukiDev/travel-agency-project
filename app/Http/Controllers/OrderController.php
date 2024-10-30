<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Utils\APIResponder;

class OrderController extends Controller
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
    public function confirm($cartId)
    {
        return $this->successResponse($this->orderService->confirm($cartId, auth()->id()), 'Order Confirmed');
    }

    /**
     * Accept an order by ID.
     */
    public function accept($orderId)
    {
        return $this->successResponse($this->orderService->accept($orderId), 'Order Accepted');
    }
}
