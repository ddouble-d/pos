<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukStoreRequest;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::latest()->paginate(2);
        return view('produk.index')->with('produk', $produk);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProdukStoreRequest $request)
    {
        $gambar_path = '';
        if ($request->hasFile('gambar')) {
            $gambar_path = $request->file('gambar')->store('produk');
        }

        $produk = Produk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->dekripsi,
            'gambar' => $gambar_path,
            'barcode' => $request->barcode,
            'harga' => $request->harga,
            'status' => $request->status
        ]);

        if (!$produk) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        } else {
            return redirect()->route('produk.index')->with('success', 'Produk Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
