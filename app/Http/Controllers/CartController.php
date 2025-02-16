<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\Utils\APIResponder;
use Illuminate\Http\JsonResponse;

final class CartController extends Controller
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

    public function index(): JsonResponse
    {
        return $this->successResponse(
            new CartResource(
                $this->cartService->showAllCarts(
                    auth()->id()))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request, string $travel, string $tour): JsonResponse
    {
        return $this->successResponse(
            $this->cartService->addItemToCart(auth()->id(),
                $request->validated(),
                $travel, $tour), 'Item added successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request, int $cartItemId): JsonResponse
    {

        return $this->successResponse(
            $this->cartService->updateItem($request->validated(),
                $cartItemId),
            'Cart updated'
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $cartItemId): JsonResponse
    {
        //
        return $this->successResponse(
            $this->cartService->deleteItem(
                $cartItemId),
            'item deleted successfully!'
        );
    }
}
