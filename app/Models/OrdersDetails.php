<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdersDetails extends Model
{

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }
}
