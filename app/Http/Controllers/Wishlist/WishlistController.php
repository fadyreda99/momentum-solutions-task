<?php

namespace App\Http\Controllers\Wishlist;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\WishlistRequest;
use App\Http\Resources\Wishlist\WishlistResource;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function addItem(WishlistRequest $request)
    {
        $user = auth()->user();

        // Check if the user has a wishlist, if not create one
        $wishlist = $user->wishlist;
        if (!$wishlist) {
            $wishlist = $user->wishlist()->create();
        }

        $product = Product::findOrFail($request->product_id);

        // Check if the item already exists in the wishlist
        $existingItem = $wishlist->wishlistItems()->where('product_id', $product->id)->first();

        if (!$existingItem) {
            // Add the item to the wishlist if it doesn't already exist
            $wishlist->wishlistItems()->create([
                'product_id' => $product->id,
            ]);
        }

        return new WishlistResource($wishlist);
    }

    public function removeItem(WishlistRequest $request)
    {
        $user = auth()->user();

        $wishlist = $user->wishlist;
        if (!$wishlist) {
            return response()->json(['message' => 'Wishlist not found'], 404);
        }

        $item = $wishlist->wishlistItems()->where('id', $request->item_id)->first();

        if ($item) {
            $item->delete();

            // Check if the wishlist is now empty
            if ($wishlist->wishlistItems()->count() === 0) {
                $wishlist->delete();
                return response()->json(['message' => 'Wishlist deleted as it is now empty'], 200);
            }
        }

        return new WishlistResource($wishlist);
    }
}
