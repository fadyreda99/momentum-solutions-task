<?php

namespace App\Repositories\Wishlist;

use App\Http\Requests\Wishlist\WishlistRequest;
use App\Http\Resources\Wishlist\WishlistResource;
use App\Models\Product;

class WishlistRepository
{
    public function addItem($request)
    {
        try {
            $user = auth()->user();
            $wishlist = $user->wishlist ?? $user->wishlist()->create();
            $product = Product::findOrFail($request->product_id);
            $existingItem = $wishlist->wishlistItems()->where('product_id', $product->id)->first();
            if (!$existingItem) {
                $wishlist->wishlistItems()->create(['product_id' => $product->id]);
            }
            return $wishlist;
        } catch (\Exception $e) {
            throw new \Exception('Unable to add item to wishlist.');
        }
    }

    public function removeItem($request)
    {
        try {
            $user = auth()->user();
            $wishlist = $user->wishlist;
            if (!$wishlist) {
                throw new \Exception('Wishlist not found');
            }
            $item = $wishlist->wishlistItems()->where('id', $request->item_id)->first();
            if ($item) {
                $item->delete();
                if ($wishlist->wishlistItems()->count() === 0) {
                    $wishlist->delete();
                    return response()->json(['message' => 'Wishlist deleted as it is now empty'], 200);
                }
            }
            return $wishlist;
        } catch (\Exception $e) {
            throw new \Exception('Unable to remove item from wishlist.');
        }
    }
}
