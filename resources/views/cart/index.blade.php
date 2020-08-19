@extends('layouts.admin')

@section('title', 'Open POS')
@section('content-header', 'Open POS')
@section('content-actions')
<a href="{{route('customer.create')}}" class="btn btn-primary float-right">Tambah</a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <div id="cart">
        
    </div>
@endsection

