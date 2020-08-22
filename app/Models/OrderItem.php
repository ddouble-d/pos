<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'harga',
        'quantity',
        'produk_id',
        'order_id'
    ];
}
