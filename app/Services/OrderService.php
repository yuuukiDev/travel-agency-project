<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Support\Facades\DB;

final class OrderService
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function confirm($cartId, $userId)
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $userId,
                'status' => OrderStatus::PENDING->value,
            ]);

            $cartItems = Cart::findOrFail($cartId)->items;

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'tour_id' => $item->tour_id,
                    'tour_name' => $item->tour->name,
                    'tour_image' => $item->tour->tourImages()->first()->image_path,
                    'qty' => $item->qty,
                    'price' => $item->tour->price,
                    'sub_total' => $item->total,
                ]);
            }
            DB::commit();

            return $order;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function accept($orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'status' => OrderStatus::ACCEPTED->value,
        ]);

        return $this->ticketService->generateAndSendTicket($orderId);
    }
}
