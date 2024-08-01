<?php

namespace App\Services\Cart;

use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\CartItems;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Log;

class CartService
{
    public function __construct(private CartRepository $cartRepository)
    {
    }

    public function addItem($request)
    {
        $request->merge(['id'=>$request->product_id]);
        $cart = $this->cartRepository->addItem($request);
        return new CartResource($cart);
    }

    public function updateItem( $request)
    {
        $cart = $this->cartRepository->updateItem($request);
        return new CartResource($cart);
    }

    public function removeItem( $request)
    {
        $cart= $this->cartRepository->removeItem($request);
        return new CartResource($cart);
    }

    public function viewCart()
    {
        try {
            $cart = $this->cartRepository->viewCart();
            return new CartResource($cart);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
