<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout()
    {
        $user = auth()->user();

        // Retrieve user's cart
        $cart = $user->cart;
        if (!$cart) {
            return response()->json(['message' => 'Your cart is empty. Please add items to your cart.'], 404);
        }

        // Fetch cart items
         $cartItems = $cart->cartItems;
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty. Please add items to your cart.'], 400);
        }

        // Calculate subtotal
        $subTotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Define shipping cost (as a variable)
        $shippingCost = 10.00; // Example fixed shipping cost

        // Calculate total
         $total = $subTotal + $shippingCost;

        // Create order
        $order = $user->orders()->create([
            'order_code' => $this->generateOrderCode(),
            'sub_total' => $subTotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
        ]);

        // Add order items
        foreach ($cartItems as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }

        // Clear cart (optional)
        $cart->cartItems()->delete();
        $cart->delete();
        return new OrderResource($order);
    }

    private function generateOrderCode()
    {
        $lastOrder = Order::latest('id')->first();
        $nextId = ($lastOrder ? $lastOrder->id + 1 : 1);
        $orderCode = sprintf('ord-%05d', $nextId);

        return $orderCode;
    }
}
