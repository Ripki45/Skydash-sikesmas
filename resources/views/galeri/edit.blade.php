@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Foto Galeri</h4>
                <form class="forms-sample" action="{{ route('galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Gambar Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $galeri->path_gambar) }}" alt="{{ $galeri->judul }}" class="img-fluid" style="max-width: 300px; border-radius: 5px;">
                        </div>
                    </div>
                     <div class="form-group">
                        <label>Ganti Gambar</label>
                        <input type="file" name="path_gambar" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar (Max 2MB)...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Foto</label>
                        <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required>
                    </div>
                     <div class="form-group">
                        <label for="galeri_kategori_id">Kategori (Opsional)</label>
                        <select class="form-control" name="galeri_kategori_id" id="galeri_kategori_id">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                {{-- Untuk form edit, tambahkan logika 'selected' di sini --}}
                                <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="urutan">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="{{ old('urutan', $galeri->urutan) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('galeri.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
