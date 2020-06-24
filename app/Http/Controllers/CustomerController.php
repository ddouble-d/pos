<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::latest()->paginate(10);
        return view('customer.index')->with('customer', $customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $avatar_path = '';
        if ($request->hasFile('avatar')) {
            $avatar_path = $request->file('avatar')->store('customer');
        }

        $customer = Customer::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'avatar' => $avatar_path,
            'user_id' => $request->user()->id
        ]);

        if (!$customer) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        } else {
            return redirect()->route('customer.index')->with('success', 'Customer Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->nama = $request->nama;
        $customer->email = $request->email;
        $customer->hp = $request->hp;
        $customer->alamat = $request->alamat;

        if ($request->hasFile('avatar')) {
            //Hapus avatar yang di database
            \Storage::delete($customer->avatar);
            //Simpan avatar baru
            $avatar_path = $request->file('avatar')->store('customer');
            $customer->avatar = $avatar_path;
        }

        if (!$customer->save()) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        } else {
            return redirect()->route('customer.index')->with('success', 'Customer Berhasil Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if ($customer->avatar) {
            \Storage::delete($customer->avatar);
        }
        $customer->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
