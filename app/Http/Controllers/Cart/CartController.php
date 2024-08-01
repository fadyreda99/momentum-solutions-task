<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Models\CartItems;
use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct(private CartService $cartService)
    {
        $this->middleware('auth:api');
    }
    public function addItem(CartRequest $request)
    {
        return $this->cartService->addItem($request);
    }

    public function updateItem(CartRequest $request)
    {
        return $this->cartService->updateItem($request);
    }

    public function removeItem(CartRequest $request)
    {
        return $this->cartService->removeItem($request);
    }

    public function viewCart()
    {
        return $this->cartService->viewCart();
    }
}
