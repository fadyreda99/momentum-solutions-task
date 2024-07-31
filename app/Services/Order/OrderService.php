<?php

namespace App\Services\Order;

use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function __construct(private OrderRepository $orderRepository)
    {
    }
    public function checkout()
    {
        DB::beginTransaction();
        try{
            $user = auth()->user();
            $cart = $user->cart;
            if (!$cart) {
                return response()->json(['message' => 'Your cart is empty. Please add items to your cart.'], 404);
            }
            $cartItems = $cart->cartItems;
            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Your cart is empty. Please add items to your cart.'], 400);
            }
            $subTotal = $this->getSubTotal($cartItems);
            $shippingCost = 10.00; //note it should retrieve from city
            $total = $this->getTotal($subTotal, $shippingCost);
            $order = $this->orderRepository->create(user:$user, subTotal: $subTotal, shippingCost: $shippingCost, total: $total, items:$cartItems);
            $cart->cartItems()->delete();
            $cart->delete();
            DB::commit();
            return new OrderResource($order);
        }catch (\Exception $e){
            DB::rollBack();
            Log::channel('daily')->info('error in order creation' . $e->getMessage());
            return response()->json(['message' => 'something went wring please try again later'], 500);
        }

    }

    private function getSubTotal($cartItems){
        return $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    private function getTotal($subtotal , $shippingCost){
      return $subtotal + $shippingCost;
    }
}
