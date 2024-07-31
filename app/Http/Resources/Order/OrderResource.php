<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_code' => $this->order_code,
            'sub_total' => $this->sub_total,
            'shipping_cost' => $this->shipping_cost,
            'total' => $this->total,
            'items' => OrderItemsResource::collection($this->orderItems),
        ];
    }
}
