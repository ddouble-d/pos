<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = new Order();
        if($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date);
        }
        $orders = $orders->latest()->paginate(10);
        return view('order.index', compact('orders'));
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'customer_id'   => $request->customer_id,
            'user_id'       => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'harga'     => $item->harga,
                'quantity'  => $item->pivot->quantity,
                'produk_id' => $item->id
            ]);

            $item->qty = $item->qty - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }
}
