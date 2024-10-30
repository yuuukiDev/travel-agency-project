<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Services\CartService;
use App\Utils\APIResponder;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use APIResponder;
    /**
     * Display a listing of the resource.
     */

     private CartService $cartService;

     public function __construct(CartService $cartService)
     {
        $this->cartService = $cartService;
     }
    public function index()
    {
        return $this->successResponse(new CartResource($this->cartService->showAllCarts(auth()->id())));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request, $travel, $tour)
    {
        return $this->successResponse($this->cartService->addItemToCart(auth()->id(), $request->validated(), $travel, $tour), "Item added");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request, $cartItemId)
    {
        
        return $this->successResponse($this->cartService->updateItem($request->validated(), $cartItemId), "Cart updated");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cartItemId)
    {
        //
        return $this->successResponse($this->cartService->deleteItem($cartItemId),"item deleted successfully!");
    }
}
