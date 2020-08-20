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
        
        return response('', 204);
    }

    public function changeQty(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'quantity'  => 'required|integer|min:1'
        ]);

        $cart = $request->user()->cart()->where('produk_id', $request->produk_id)->first();

        if($cart) {
            $cart->pivot->quantity = $request->quantity;
            $cart->pivot->save();
        }

        return response([
            'success' => true
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|integer|exists:produks,id'
        ]);
        $request->user()->cart()->detach($request->produk_id);

        return response('', 204);
    }

    public function empty(Request $request)
    {
        $request->user()->cart()->detach();

        return response('', 204);
    }
}
