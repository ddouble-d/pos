@extends('layouts.admin')

@section('title', 'Setting')
@section('content-header', 'Setting')
@section('content')
<div class="card">
    <div class="card-body">  
<form action="{{route('setting.store')}}" method="POST" enctype="multipart/form-data">
@csrf
<div class="form-group">
    <label for="nama_app">Nama Aplikasi</label>
    <input type="text" name="nama_app" class="form-control @error('nama_app') is-invalid @enderror" 
        id="nama_app" placeholder="Nama Aplikasi" value="{{ old('nama_app', config('setting.nama_app')) }}" autofocus>
    @error('nama_app')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>    
<div class="form-group">
    <label for="deskripsi_app">Deskripsi Aplikasi</label>
    <textarea name="deskripsi_app" class="form-control @error('deskripsi_app') is-invalid @enderror" 
        id="deskripsi_app" placeholder="Deskripsi Aplikasi" autofocus>{{ old('deskripsi_app', config('setting.deskripsi_app')) }}</textarea>
    @error('deskripsi_app')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label for="simbol">Simbol Mata Uang</label>
    <input type="text" name="simbol" class="form-control @error('simbol') is-invalid @enderror" 
        id="simbol" placeholder="Simbol Mata Uang" value="{{ old('simbol', config('setting.simbol')) }}" autofocus>
    @error('simbol')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>    
<button class="btn btn-primary" type="submit">Ubah Setting</button>
</form>
      
</div>
</div>
@endsection