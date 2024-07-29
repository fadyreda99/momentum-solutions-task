<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = ['user_id', 'order_code', 'sub_total', 'shipping_cost', 'total'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orderItems(){
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }
}
