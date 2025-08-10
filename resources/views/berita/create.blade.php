@extends('layouts.app')

@section('content')
<form class="forms-sample" action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    {{-- KOLOM KIRI --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Buat Berita Baru</h4>
                @if ($errors->any())
                    {{-- Error handling --}}
                @endif
                <div class="form-group">
                    <label for="judul">Judul Berita</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Berita" value="{{ old('judul') }}" required>
                </div>
                <div class="form-group">
                    <label for="isi_berita">Isi Berita</label>
                    <textarea class="form-control" id="isi_berita" name="isi_berita" rows="15">{{ old('isi_berita') }}</textarea>
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
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="published_at">Tanggal Publikasi</label>
                    <input type="date" class="form-control" id="published_at" name="published_at" value="{{ date('Y-m-d') }}">
                    <small class="form-text text-muted">Kosongkan untuk terbit sekarang.</small>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary btn-block">Simpan & Publikasikan</button>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Kategori</h4>
                 <div class="form-group">
                    <select class="form-control" name="kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Tags</h4>
                 <div class="form-group">
                    {{-- 'tags[]' memungkinkan kita mengirim banyak nilai --}}
                    <select class="form-control" name="tags[]" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->nama_tag }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gambar Unggulan</h4>
                <div class="form-group">
                    <input type="file" name="gambar_unggulan" class="file-upload-default" required>
                    <div class="input-group">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar...">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
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
