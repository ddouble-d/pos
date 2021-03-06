@extends('layouts.admin')

@section('title', 'Daftar Produk')
@section('content-header', 'Daftar Produk')
@section('content-actions')
<a href="{{route('produk.create')}}" class="btn btn-primary float-right">Tambah</a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
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
                    <th>Qty</th>
                    <th>Status</th>
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
                    <td>{{$data->qty}}</td>
                    <td>
                    <span class="right badge badge-{{$data->status ? 'success' : 'danger'}}">{{$data->status ? 'Aktif' : 'Tidak Aktif'}}</span>
                    </td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->updated_at}}</td>
                    <td>
                        <a href="{{ route('produk.edit',$data )}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        {{-- <a href="{{route('produk.show',$data->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a> --}}
                    <button class="btn btn-danger btn-delete" data-url="{{ route('produk.destroy',$data) }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$produk->render()}}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-delete', function() {
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title: 'Hapus data?',
            text: "Data akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus data!',
            cancelButtonText: 'Batalkan!',
            reverseButtons: true
            }).then((result) => {
            if (result.value) {
                $.post($this.data('url'), {_method: 'DELETE', _token: '{{ csrf_token() }}'}, function(res){
                    $this.closest('tr').fadeOut(500, function(){
                        $(this).remove();
                    })
                })                
            }
            })
        })
    })
</script>
@endsection

