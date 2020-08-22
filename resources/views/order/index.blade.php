@extends('layouts.admin')

@section('title', 'Daftar Order')
@section('content-header', 'Daftar Order')
@section('content-actions')
<a href="{{route('cart.index')}}" class="btn btn-primary float-right">Open POS</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('orders.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="date" name="start_date" value="{{request('start_date')}}">
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" value="{{request('end_date')}}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-sm btn-outline-primary float-right">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Customer</th>
                    <th>Total</th>
                    <th>Diterima</th>
                    <th>Status</th>
                    <th>Kembalian / Kurang</th>
                    <th>Dibuat Pada</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $data)       
                <tr>
                    <td>{{$data->id}}</td>
                    <td>{{$data->getCustomerName()}}</td>
                    <td>{{config('setting.simbol')}} {{$data->total()}}</td>
                    <td>{{config('setting.simbol')}} {{$data->receivedAmount()}}</td>
                    <td>
                        @if ($data->receivedAmount() < $data->total())
                        <span class="badge badge-danger">Belum Lunas</span>
                        @elseif ($data->receivedAmount() > $data->total())
                        <span class="badge badge-info">Kembali</span>
                        @else
                        <span class="badge badge-success">Lunas</span>
                        @endif
                    </td>
                    <td>{{config('setting.simbol')}} {{$data->total() - $data->receivedAmount()}}</td>
                    <td>{{$data->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$orders->render()}}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection

