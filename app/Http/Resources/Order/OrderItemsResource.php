<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Products\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemsResource extends JsonResource
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
            'product' => new ProductResource($this->product),

            'quantity' => $this->quantity,
            'total' => $this->quantity * $this->product->price,
        ];
    }
}
