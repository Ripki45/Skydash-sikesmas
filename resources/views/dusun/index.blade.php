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

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manajemen Dusun</h4>
                <p class="card-description">
                    Kelola semua data dusun di wilayah kerja Anda.
                </p>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.dusun.create') }}" class="btn btn-primary">Tambah Dusun Baru</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Dusun</th>
                                <th>Desa Induk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dusuns as $dusun)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dusun->nama_dusun }}</td>
                                    <td>{{ $dusun->desa->nama_desa }}</td>
                                    {{-- <td>
                                        <a href="{{ route('admin.dusun.edit', $dusun->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-url="{{ route('admin.dusun.destroy', $dusun->id) }}">
                                            Hapus
                                        </button>
                                    </td> --}}
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.dusun.edit', $dusun->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                        data-url="{{ route('admin.dusun.destroy', $dusun->id) }}">
                                                        Hapus
                                                </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data dusun yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus halaman ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
