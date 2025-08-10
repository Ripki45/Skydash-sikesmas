@extends('layouts.app')

@section('content')
<form class="forms-sample" action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="row">
    {{-- KOLOM KIRI --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Berita</h4>
                <div class="form-group">
                    <label for="judul">Judul Berita</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required>
                </div>
                <div class="form-group">
                    <label for="isi_berita">Isi Berita</label>
                    <textarea class="form-control" id="isi_berita" name="isi_berita" rows="15">{{ old('isi_berita', $berita->isi_berita) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN --}}
    <div class="col-md-4 grid-margin">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Publikasi</h4>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="published_at">Tanggal Publikasi</label>
                    {{-- Format tanggal agar sesuai dengan input type="date" --}}
                    <input type="date" class="form-control" id="published_at" name="published_at" value="{{ old('published_at', \Carbon\Carbon::parse($berita->published_at)->format('Y-m-d')) }}">
                </div>
                <hr>
                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Kategori</h4>
                 <div class="form-group">
                    <select class="form-control" name="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $berita->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Tags</h4>
                 <div class="form-group">
                    {{-- 'contains' digunakan untuk memeriksa apakah tag ada di dalam relasi --}}
                    <select class="form-control" name="tags[]" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ $berita->tags->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->nama_tag }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gambar Unggulan</h4>
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" alt="Gambar Unggulan" class="img-fluid" style="max-height: 150px;">
                </div>
                <div class="form-group">
                    <label>Ganti Gambar</label>
                    <input type="file" name="gambar_unggulan" class="file-upload-default">
                    <div class="input-group">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar...">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create( document.querySelector( '#isi_berita' ) );
</script>
@endsection
