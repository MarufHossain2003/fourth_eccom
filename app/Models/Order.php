<?php

namespace App\Models;

use App\Models\OrderDetails;
use App\Models\ReturnProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id')->with('product');
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class, 'order_id', 'id')->with('order');
    }
}

// order has many to orderDetails
// order has many ReturnProduct