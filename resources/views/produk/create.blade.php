@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('content-header', 'Tambah Produk')
@section('content')
<div class="card">
    <div class="card-body">  
<form action="{{route('produk.store')}}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
            id="nama" placeholder="Nama Produk" value="{{ old('nama') }}" autofocus>
        @error('nama')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>    
    <div class="form-group">
        <label for="deskripsi">Deskripsi</label>
        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
            id="deskripsi" placeholder="Deskripsi" autofocus>{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="gambar">Gambar</label>
        <div class="custom-file">
        <input type="file" name="gambar" class="custom-file-input" 
    id="gambar" value="{{old('gambar')}}" >
    <label for="gambar" class="custom-file-label">Pilih Gambar</label>    
</div>
    @error('gambar')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="barcode">Barcode</label>
        <input type="text" name="barcode" class="form-control @error('barcode') is-invalid @enderror" 
            id="barcode" placeholder="Barcode" value="{{ old('barcode') }}" autofocus>
        @error('barcode')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="harga">Harga</label>
        <input type="text" name="harga" class="form-control @error('harga') is-invalid @enderror" 
            id="harga" placeholder="Harga" value="{{ old('harga') }}" autofocus>
        @error('harga')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control @error('status') is-invalid @enderror" 
            id="status" placeholder="status" autofocus>
        <option value="1" {{old('status') === 1 ? 'selected' : ''}}>Aktif</option>
        <option value="0" {{old('status') === 0 ? 'selected' : ''}}>Tidak Aktif</option>
        </select>
        @error('status')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <button class="btn btn-primary" type="submit">Simpan</button>
</form>
      
</div>
</div>
@endsection

@section('js')
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
</script>
@endsection