<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
     protected $fillable = [
        'product_id',
        'imei1',
        'buy_price',
        'sell_price',
        'category_type',
        'status_stok',
    ];

   public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
