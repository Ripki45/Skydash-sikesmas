@extends('layouts.app')

@section('content')

{{-- Menampilkan notifikasi sukses jika ada --}}
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
                <h4 class="card-title">Manajemen Halaman</h4>
                <p class="card-description">
                    Kelola semua halaman konten dinamis untuk website Anda.
                </p>
                <div class="d-flex justify-content-end mb-3">
                    {{-- Tombol ini akan kita fungsikan nanti --}}
                    <a href="#" class="btn btn-primary">Buat Halaman Baru</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($halamans as $halaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $halaman->judul }}</td>
                                    <td>
                                        {{-- Memberi warna berbeda untuk setiap status --}}
                                        @if($halaman->status == 'published')
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                    </td>
                                    {{-- Format tanggal agar lebih mudah dibaca --}}
                                    <td>{{ $halaman->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-sm">View</a>
                                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada halaman yang dibuat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
