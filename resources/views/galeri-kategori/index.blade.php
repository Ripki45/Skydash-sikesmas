@extends('layouts.app')

@section('content')

{{-- Menampilkan Notifikasi --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
@endif

<div class="row">
    {{-- KOLOM KIRI: FORM DINAMIS --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $kategoriToEdit ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h4>
                <form class="forms-sample"
                      action="{{ $kategoriToEdit ? route('galeri-kategori.update', $kategoriToEdit->id) : route('galeri-kategori.store') }}"
                      method="POST">
                    @csrf
                    @if($kategoriToEdit)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror"
                               name="nama_kategori" id="nama_kategori"
                               value="{{ old('nama_kategori', $kategoriToEdit->nama_kategori ?? '') }}"
                               placeholder="Contoh: Kegiatan Posyandu" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">{{ $kategoriToEdit ? 'Simpan Perubahan' : 'Simpan' }}</button>
                    @if($kategoriToEdit)
                        <a href="{{ route('galeri-kategori.index') }}" class="btn btn-light">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: TABEL DAFTAR KATEGORI --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Kategori Galeri</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Jumlah Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>{{ $kategori->slug }}</td>
                                <td>{{ $kategori->galeris()->count() }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('galeri-kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm"
                                            data-toggle="modal" data-target="#deleteModal"
                                            data-url="{{ route('galeri-kategori.destroy', $kategori->id) }}">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada kategori.</td>
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
