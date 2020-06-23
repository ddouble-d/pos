<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdukStoreRequest;
use App\Http\Requests\ProdukUpdateRequest;
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
        $produk = Produk::latest()->paginate(10);
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
            'qty' => $request->qty,
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
        return view('produk.edit')->with('produk', $produk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(ProdukUpdateRequest $request, Produk $produk)
    {
        $produk->nama = $request->nama;
        $produk->deskripsi = $request->deskripsi;
        $produk->barcode = $request->barcode;
        $produk->harga = $request->harga;
        $produk->qty = $request->qty;
        $produk->status = $request->status;

        if ($request->hasFile('gambar')) {
            //Hapus gambar yang di database
            \Storage::delete($produk->gambar);
            //Simpan gambar baru
            $gambar_path = $request->file('gambar')->store('produk');
            $produk->gambar = $gambar_path;
        }

        if (!$produk->save()) {
            return redirect()->back()->with('error', 'Terjadi Kesalahan');
        } else {
            return redirect()->route('produk.index')->with('success', 'Produk Berhasil Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        if ($produk->gambar) {
            \Storage::delete($produk->gambar);
        }
        $produk->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
