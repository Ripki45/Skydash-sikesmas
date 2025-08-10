@extends('layouts.app')

@section('content')

{{-- Form akan membungkus kedua kolom --}}
<form class="forms-sample" action="{{ route('admin.halaman.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">
    {{-- KOLOM KIRI (KONTEN UTAMA) --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Buat Halaman Baru</h4>
                <p class="card-description">
                    Isi detail konten untuk halaman website baru.
                </p>

                {{-- Menampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="judul">Judul Halaman</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Halaman" value="{{ old('judul') }}" required>
                </div>

                <div class="form-group">
                    <label for="konten">Konten Halaman</label>
                    {{-- Nanti kita akan pasang CKEditor di textarea dengan id="konten" ini --}}
                    <textarea class="form-control" id="konten" name="konten" rows="15">{{ old('konten') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN (PENGATURAN) --}}
    <div class="col-md-4 grid-margin">
        {{-- Card untuk Publikasi --}}
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Pengaturan Publikasi</h4>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        {{--
                            REVISI: Logikanya disamakan dengan yang 'published'.
                            Cek apakah old('status') nilainya 'draft'. Jika ya, maka 'selected'.
                        --}}
                        <option value="draft" {{ old('status', 'draft', 'selected') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary btn-block">Simpan Halaman</button>
                <a href="{{ route('admin.halaman.index') }}" class="btn btn-light btn-block mt-2">Batal</a>
            </div>
        </div>

        {{-- Card untuk Induk Menu --}}
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Induk Menu</h4>
                 <div class="form-group">
                    <label for="kluster_id">Hubungkan ke Menu</label>
                    <select class="form-control" id="kluster_id" name="kluster_id">
                        <option value="">-- Tidak Terhubung --</option>
                        @foreach($klusters as $kluster)
                            <option value="{{ $kluster->id }}" {{ old('kluster_id') == $kluster->id ? 'selected' : '' }}>
                                {{ $kluster->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Card untuk Gambar Unggulan --}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gambar Unggulan</h4>
                <div class="form-group">
                    <label for="gambar_unggulan">Upload Gambar</label>
                    <input type="file" name="gambar_unggulan" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar...">
                        <span class="input-group-append ms-2">
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
{{-- Memanggil library CKEditor dari CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

{{-- Script untuk mengaktifkan CKEditor pada textarea dengan id="konten" --}}
<script>
    ClassicEditor
        .create( document.querySelector( '#konten' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection
