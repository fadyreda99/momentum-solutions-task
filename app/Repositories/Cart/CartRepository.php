<?php

namespace App\Repositories\Cart;

use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\CartItems;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;

class CartRepository
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function addItem($request)
    {
        $user = auth()->user();
        $cart = $this->checkCart($user);
        $product = $this->productRepository->show($request);
        $existingItem = $cart->cartItems()->where('product_id', $product->id)->first();
        if ($existingItem) {
            $newQuantity = $existingItem->quantity + ($request->quantity ?? 1);
            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price,
            ]);
        }
        $cart->load('cartItems');
        return $cart;
    }

    public function updateItem(CartRequest $request)
    {
        $item = CartItems::findOrFail($request->item_id);
        $item->update([
            'quantity' => $request->quantity,
        ]);
        return $item->cart;
    }

    public function removeItem(CartRequest $request)
    {
        $item = CartItems::findOrFail($request->item_id);
        $cart = $item->cart;
        $item->delete();
        if ($cart->cartItems()->count() === 0) {
            $cart->delete();
        }
        return $cart;
    }

    public function viewCart()
    {
        $user = auth()->user();
        $cart = $this->checkCart($user);
        if (!$cart || $cart->cartItems->isEmpty()) {
            throw new \Exception('Cart is empty');
        }
        return $cart;
    }

    private function checkCart($user){
        $user = auth()->user();
        $cart = $user->cart;
        if (!$cart) {
            $cart = $user->cart()->create();
        }
        return $cart;
    }
}
