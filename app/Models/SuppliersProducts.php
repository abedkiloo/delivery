<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuppliersProducts extends Model
{
    protected $table = 'suppliers_products';


    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Products::class, 'supply_id', 'id');
    }
}
