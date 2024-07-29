<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishlistItems extends Model
{
    use HasFactory;
    protected $table = 'wishlist_items';
    protected $fillable = ['wishlist_id', 'product_id'];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class, 'wishlist_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
