<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
     protected $fillable = [
        'sale_id',
        'product_id',
        'product_unit_id',
        'product_name',
        'imei1',
        'buy_price',
        'sell_price',
        'qty',
        'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }

   
}
