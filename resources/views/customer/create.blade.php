@extends('layouts.admin')

@section('title', 'Tambah Customer')
@section('content-header', 'Tambah Customer')
@section('content')
<div class="card">
    <div class="card-body">  
<form action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
            id="nama" placeholder="Nama Customer" value="{{ old('nama') }}" autofocus>
        @error('nama')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
            id="email" placeholder="Email" value="{{ old('email') }}" autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="hp">HP</label>
        <input type="string" name="hp" class="form-control @error('hp') is-invalid @enderror" 
            id="hp" placeholder="HP" value="{{ old('hp') }}" autofocus>
        @error('hp')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
            id="alamat" placeholder="Alamat" autofocus>{{ old('alamat') }}</textarea>
        @error('alamat')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="avatar">Avatar</label>
        <div class="custom-file">
        <input type="file" name="avatar" class="custom-file-input" 
            id="avatar" value="{{old('avatar')}}" >
            <label for="avatar" class="custom-file-label">Pilih Avatar</label>    
        </div>
        @error('avatar')
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