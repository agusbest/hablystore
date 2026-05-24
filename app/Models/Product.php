<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = [
        'brand',
        'model',
        'tipe',
        'ram',
        'rom',
        'color',
    ];

    public function units()
    {
        return $this->hasMany(ProductUnit::class);
    }
}
