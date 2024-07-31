<?php

namespace App\Repositories\Order;

use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function create($user, $subTotal, $shippingCost, $total, $items){
        $order = $user->orders()->create([
            'order_code' => generate_order_code(),
            'sub_total' => $subTotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
        ]);
        $this->createOrderItems($order, $items);
        return $order;
    }

    private function createOrderItems($order, $items){
        foreach ($items as $item) {
            $order->orderItems()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
            ]);
        }
    }
}
