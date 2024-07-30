<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //product model
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'inventory'];

    public function wishlistItems(){
        return $this->hasMany(WishlistItems::class, 'product_id', 'id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItems::class, 'product_id', 'id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class, 'product_id', 'id');
    }
}
