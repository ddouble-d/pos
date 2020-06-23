@extends('layouts.admin')

@section('title', 'Daftar Customer')
@section('content-header', 'Daftar Customer')
@section('content-actions')
<a href="{{route('customer.create')}}" class="btn btn-primary float-right">Tambah</a>
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
                    <th>Avatar</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Alamat</th>
                    <th>Dibuat Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customer as $data)       
                <tr>
                    <td>{{$data->id}}</td>
                <td><img src="{{ $data->getAvatarUrl() }}" width="50" alt=""></td>
                    <td>{{$data->nama}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->hp}}</td>
                    <td>{{$data->alamat}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>
                        <a href="{{ route('customer.edit',$data )}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        {{-- <a href="{{route('customer.show',$data->id)}}" class="btn btn-info"><i class="fas fa-eye"></i></a> --}}
                    <button class="btn btn-danger btn-delete" data-url="{{ route('customer.destroy',$data) }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$customer->render()}}
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

