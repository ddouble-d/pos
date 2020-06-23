<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $produk_id = $this->route('produk')->id;
        return [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image',
            'barcode' => 'required|string|max:50|unique:produks,barcode,' . $produk_id,
            'harga' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qty' => 'required|integer',
            'status' => 'required|boolean',
        ];
    }
}
