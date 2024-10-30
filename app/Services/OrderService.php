<?php
namespace App\Services;

use App\Services\TicketService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Utils\Constants;
use Illuminate\Support\Facades\DB;

class OrderService
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
                'status' => Constants::$ORDER_PENDING,
            ]);

            $cartItems = Cart::findOrFail($cartId)->items;

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'tour_id' => $item->tour_id,
                    'qty' => $item->qty,
                    'price' => $item->total,
                ]);
            }
            DB::commit();
            
            return $order;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function accept($orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'status' => Constants::$ORDER_ACCEPTED
        ]);

        return $this->ticketService->generateAndSendTicket($orderId);
    }
}
