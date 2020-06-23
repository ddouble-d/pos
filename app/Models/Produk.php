<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'barcode',
        'harga',
        'qty',
        'status'
    ];
}
