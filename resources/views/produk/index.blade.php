@extends('layouts.admin')

@section('title', 'Daftar Produk')
@section('content-header', 'Daftar Produk')
@section('content-actions')
<a href="{{route('produk.create')}}" class="btn btn-primary float-right">Tambah</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Barcode</th>
                    <th>Harga</th>
                    <th>Dibuat Pada</th>
                    <th>Diupdate Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $data)       
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->nama}}</td>
                    <td>{{$data->deskripsi}}</td>
                <td><img src="{{Storage::url($data->gambar)}}" alt="" width="100"></td>
                    <td>{{$data->barcode}}</td>
                    <td>{{$data->harga}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->updated_at}}</td>
                    <td>
                        <a href="{{route('produk.edit',$data->id)}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <a href="{{route('produk.show',$data->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$produk->render()}}
    </div>
</div>

@endsection