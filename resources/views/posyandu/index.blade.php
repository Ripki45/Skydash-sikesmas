@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Manajemen Posyandu</h4>
        <p class="card-description">Kelola semua data posyandu di wilayah kerja Anda.</p>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('posyandu.create') }}" class="btn btn-primary">Tambah Posyandu Baru</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Posyandu</th>
                        <th>Dusun</th>
                        <th>Desa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posyandus as $posyandu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $posyandu->nama_posyandu }}</td>
                            <td>{{ $posyandu->dusun->nama_dusun }}</td>
                            <td>{{ $posyandu->dusun->desa->nama_desa }}</td>
                            <td>
                                <a href="{{ route('posyandu.edit', $posyandu->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-url="{{ route('posyandu.destroy', $posyandu->id) }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data posyandu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
