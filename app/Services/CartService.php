<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Exception;
use Illuminate\Support\Facades\DB;

final class CartService
{
    public function showAllCarts($userId)
    {
        return Cart::with('items')
            ->where('user_id', $userId)
            ->first();
    }

    public function addItemToCart($userId, $data, $travel, $tour)
    {
        try {
            DB::beginTransaction();

            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            $item = CartItem::where('cart_id', $cart->id)
                ->where('tour_id', $tour)
                ->first();

            $cartItem = $this->incrementOrCreateItem(
                $item,
                $cart->id,
                $tour,
                $data['qty']
            );

            DB::commit();

            return $cartItem;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateItem($data, $cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);

        $item->update([
            'qty' => $data['qty'],
        ]);

        return $item;
    }

    public function deleteItem($cartItemId)
    {
        CartItem::findOrFail($cartItemId)->delete();
    }

    /**
     * Create a new class instance.
     */
    private function incrementOrCreateItem($item, $cartId, $tourId, $qty)
    {
        if ($item) {

            $item->increment('qty', $qty);

            return $item;

        }

        return CartItem::create([
            'cart_id' => $cartId,
            'tour_id' => $tourId,
            'qty' => $qty,
        ]);

    }
}
