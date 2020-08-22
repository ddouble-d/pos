<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerName()
    {
        if($this->customer) {
            return $this->customer->nama;
        }
        return 'Guest';
    }

    public function total()
    {
        $tot_harga = $this->items->map(function($i) {
            return $i->harga;
        })->sum();

        return number_format($tot_harga, 0, ',', '.');
    }

    public function receivedAmount()
    {
        $tot_amount = $this->payments->map(function($i) {
            return $i->amount;
        })->sum();

        return number_format($tot_amount, 0, ',', '.');
    }
}
