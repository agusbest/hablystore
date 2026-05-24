<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
     protected $fillable = [
        'invoice_number',
        'sale_date',
        'customer_name',
        'subtotal',
        'discount',
        'grand_total',
        'paid_amount',
        'change_amount',
        'payment_method',
        'status',
        'notes',
        'user_id'
    ];

    public function details()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
