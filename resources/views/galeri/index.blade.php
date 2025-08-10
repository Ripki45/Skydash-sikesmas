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
                <h4 class="card-title">Manajemen Galeri</h4>
                <p class="card-description">
                    Kelola semua foto kegiatan yang akan ditampilkan di website.
                </p>
                <div class="d-flex justify-content-end mb-3">
                    {{-- Tombol ini akan kita fungsikan nanti --}}
                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">Tambah Foto Baru</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($galeris as $galeri)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $galeri->path_gambar) }}" alt="{{ $galeri->judul }}" style="width: 100px; height: 70px; object-fit: cover; border-radius: 8px;">
                                    </td>
                                    <td>{{ $galeri->judul }}</td>
                                    <td>
                                        {{-- REVISI: Panggil nama kategori dari relasi --}}
                                        <span class="badge badge-info">{{ $galeri->kategori->nama_kategori ?? 'Umum' }}</span>
                                    </td>
                                    <td>{{ $galeri->urutan }}</td>
                                    {{-- <td>
                                            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <button type-="button" class="btn btn-danger btn-sm"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-url="{{ route('admin.galeri.destroy', $galeri->id) }}">
                                                Hapus
                                            </button>
                                        </td> --}}
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                        data-url="{{ route('admin.galeri.destroy', $galeri->id) }}">
                                                        Hapus
                                                </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada foto yang ditambahkan ke galeri.</td>
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
