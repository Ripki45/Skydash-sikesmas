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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    {{-- KOLOM KIRI: FORM DINAMIS --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{-- Judul form berubah secara dinamis --}}
                <h4 class="card-title">{{ isset($kategoriToEdit) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h4>

                {{-- Action form juga berubah secara dinamis --}}
                <form class="forms-sample"
                      action="{{ isset($kategoriToEdit) ? route('kategori.update', $kategoriToEdit->id) : route('kategori.store') }}"
                      method="POST">
                    @csrf
                    {{-- Jika ini form edit, tambahkan method PUT --}}
                    @if(isset($kategoriToEdit))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        {{-- Value input diisi dengan data yang akan diedit jika ada --}}
                        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori"
                               value="{{ old('nama_kategori', $kategoriToEdit->nama_kategori ?? '') }}"
                               placeholder="Nama Kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        {{ isset($kategoriToEdit) ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                    {{-- Jika sedang mengedit, tampilkan tombol Batal --}}
                    @if(isset($kategoriToEdit))
                        <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: TABEL DAFTAR KATEGORI --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Kategori</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoris as $kategori)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kategori->nama_kategori }}</td>
                                <td>{{ $kategori->slug }}</td>
                                <td>
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type-="button" class="btn btn-danger btn-sm"
                                    data-toggle="modal" data-target="#deleteModal"
                                        data-url="{{ route('kategori.destroy', $kategori->id) }}">
                                        Hapus
                                </button>
                            </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada kategori.</td>
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
