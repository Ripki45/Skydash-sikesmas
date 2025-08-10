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
    {{-- KOLOM KIRI: FORM TAMBAH / EDIT --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ isset($tagToEdit) ? 'Edit Tag' : 'Tambah Tag Baru' }}</h4>
                <form class="forms-sample"
                      action="{{ isset($tagToEdit) ? route('admin.tag.update', $tagToEdit->id) : route('admin.tag.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($tagToEdit))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="nama_tag">Nama Tag</label>
                        <input type="text" class="form-control" name="nama_tag" id="nama_tag"
                               value="{{ old('nama_tag', $tagToEdit->nama_tag ?? '') }}"
                               placeholder="Nama Tag" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">
                        {{ isset($tagToEdit) ? 'Simpan Perubahan' : 'Simpan' }}
                    </button>
                    @if(isset($tagToEdit))
                        <a href="{{ route('admin.tag.index') }}" class="btn btn-light">Batal</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: TABEL DAFTAR TAG --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Tag</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Tag</th>
                                <th>Slug</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tag->nama_tag }}</td>
                                <td>{{ $tag->slug }}</td>
                                {{-- <td class="d-flex">
                                    <a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn btn-warning btn-sm mr-2">Edit</a>
                                    <form action="{{ route('admin.tag.destroy', $tag->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus tag ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td> --}}
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.tag.edit', $tag->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-toggle="modal" data-target="#deleteModal"
                                                    data-url="{{ route('admin.tag.destroy', $tag->id) }}">
                                                    Hapus
                                            </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada tag.</td>
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
