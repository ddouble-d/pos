<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'gambar' => $this->gambar,
            'barcode' => $this->barcode,
            'harga' => $this->harga,
            'qty' => $this->qty,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'image_url' => \Storage::url($this->gambar)
        ];
    }
}
