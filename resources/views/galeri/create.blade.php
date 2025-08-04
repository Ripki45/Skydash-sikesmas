@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Foto Baru ke Galeri</h4>
                <form class="forms-sample" action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="path_gambar" class="file-upload-default" required>
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar (Max 2MB)...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul Foto</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: Kegiatan Posyandu Mei 2024" required>
                    </div>
                    <div class="form-group">
                        <label for="galeri_kategori_id">Kategori</label>
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
                        <input type="number" class="form-control" id="urutan" name="urutan" value="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('galeri.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
