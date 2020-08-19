<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if($request->wantsJson()) {
            return response(
                $request->user()->cart()->get()
            );
        }
        return view('cart.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|exists:produks,barcode'
        ]);

        $barcode= $request->barcode;

        $cart = $request->user()->cart()->where('barcode', $barcode)->first();
        if($cart) {
            // update only quantity
            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();
        } else {
            $produk = Produk::where('barcode', $barcode)->first();
            $request->user()->cart()->attach($produk->id, ['quantity' => 1]);
        }
        
        return response('', 200);
    }
}
