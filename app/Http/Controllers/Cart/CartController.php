<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addItem(CartRequest $request)
    {
        $user = auth()->user();

        // Check if the user has a cart, if not create one
        $cart = $user->cart;
        if (!$cart) {
            $cart = $user->cart()->create();
        }

        $product = Product::findOrFail($request->product_id);

        // Check if the item already exists in the cart
        $existingItem = $cart->cartItems()->where('product_id', $product->id)->where('user_id', $user->id)->first();

        if ($existingItem) {
            // If the item exists, update the quantity
            $existingItem->update([
                'quantity' => $existingItem->quantity + ($request->quantity ?? 1),
            ]);
        } else {
            // If the item does not exist, add it to the cart
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 1,
                'price' => $product->price,
            ]);
        }

        return new CartResource($cart);
    }

    public function updateItem(CartRequest $request)
    {
        $item = CartItems::findOrFail($request->item_id);
        $item->update([
            'quantity' => $request->quantity,
        ]);

        return new CartResource($item->cart);
    }

    public function removeItem(CartRequest $request)
    {
        // Find the cart item
        $item = CartItems::findOrFail($request->item_id);

        // Get the associated cart
        $cart = $item->cart;

        // Delete the cart item
        $item->delete();

        // Check if the cart has no more items
        if ($cart->cartItems()->count() === 0) {
            // Delete the cart if it has no more items
            $cart->delete();
        }

        return new CartResource($cart);
    }

    public function viewCart()
    {
        $cart = auth()->user()->cart;
        if($cart){
            return new CartResource($cart);
        }else{
            return response()->json(['message' => 'Cart is empty'], 400);
        }
    }
}
