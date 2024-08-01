<?php

namespace App\Services\Wishlist;

use App\Http\Requests\Wishlist\WishlistRequest;
use App\Http\Resources\Wishlist\WishlistResource;
use App\Models\Product;
use App\Repositories\Wishlist\WishlistRepository;
use Illuminate\Support\Facades\Log;

class WishlistService
{
    public function __construct(private WishlistRepository $wishlistRepository)
    {
    }

    public function addItem($request)
    {
        try {
            $wishlist = $this->wishlistRepository->addItem($request);
            return new WishlistResource($wishlist);
        } catch (\Exception $e) {
            Log::error("WishlistService Error: {$e->getMessage()}");
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function removeItem( $request)
    {
        try {
            $wishlist = $this->wishlistRepository->removeItem($request);
           if(!$wishlist->message){
               return new WishlistResource($wishlist);
           }
        } catch (\Exception $e) {
            Log::error("WishlistService Error: {$e->getMessage()}");
            return response()->json(['message' => 'Wishlist deleted as it is now empty'], 500);
        }
    }
}
