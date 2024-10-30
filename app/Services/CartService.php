<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Create a new class instance.
     */

     private function incrementOrCreateItem($item, $cartId, $tourId, $qty)
     {
        if($item) {

            $item->increment('qty', $qty);
            
            } else {
            CartItem::create([
                'cart_id' => $cartId,
                'tour_id' => $tourId,
                'qty' => $qty
            ]);
        }
     }
     public function showAllCarts($userId)
     {
        return Cart::with('items')->where('user_id', $userId)->first();
     }

     public function addItemToCart($userId, $data, $travel, $tour)
     { 
        try {
            DB::beginTransaction();

            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            $item = CartItem::where('cart_id', $cart->id)
            ->where('tour_id', $tour)
            ->first();

            $this->incrementOrCreateItem($item, $cart->id, $tour, $data['qty']);

        DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
     }

     public function updateItem($data, $cartItemId)
     {
        $item = CartItem::findOrFail($cartItemId);

        $item->update([
            'qty' => $data['qty']
        ]);

        return $item;
     }

     public function deleteItem($cartItemId)
     {
        CartItem::findOrFail($cartItemId)->delete();
     }
}
