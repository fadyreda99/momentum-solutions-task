<?php

namespace App\Http\Controllers\Wishlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\WishlistRequest;
use App\Http\Resources\Wishlist\WishlistResource;
use App\Models\Product;
use App\Services\Wishlist\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function __construct(private WishlistService $wishlistService)
    {
        $this->middleware('auth:api');
    }
    public function addItem(WishlistRequest $request)
    {
        return $this->wishlistService->addItem($request);
    }

    public function removeItem(WishlistRequest $request)
    {
        return $this->wishlistService->removeItem($request);
    }
}
