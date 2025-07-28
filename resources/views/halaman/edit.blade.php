@extends('layouts.app')

@section('content')

{{-- Form diarahkan ke route 'halaman.update' dan harus menggunakan method 'POST' --}}
{{-- Kita juga menambahkan @method('PUT') untuk memberitahu Laravel ini adalah proses UPDATE --}}
<form class="forms-sample" action="{{ route('halaman.update', $halaman->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    {{-- KOLOM KIRI (KONTEN UTAMA) --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{-- Judul dibuat dinamis sesuai data yang sedang diedit --}}
                <h4 class="card-title">Edit Halaman: {{ $halaman->judul }}</h4>
                <p class="card-description">
                    Perbarui detail konten halaman ini.
                </p>

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
                    {{-- 'value' diisi dengan data lama (jika ada error) atau data dari database --}}
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Halaman" value="{{ old('judul', $halaman->judul) }}" required>
                </div>

                <div class="form-group">
                    <label for="konten">Konten Halaman</label>
                    {{-- Textarea diisi dengan data lama atau data dari database --}}
                    <textarea class="form-control" id="konten" name="konten" rows="15">{{ old('konten', $halaman->konten) }}</textarea>
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
                        {{-- Logika 'selected' untuk memilih opsi yang sesuai dengan data di database --}}
                        <option value="published" {{ old('status', $halaman->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $halaman->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                <a href="{{ route('halaman.index') }}" class="btn btn-light btn-block mt-2">Batal</a>
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
                             {{-- Logika 'selected' untuk dropdown Induk Menu --}}
                            <option value="{{ $kluster->id }}" {{ old('kluster_id', $halaman->kluster_id) == $kluster->id ? 'selected' : '' }}>
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
                {{-- Menampilkan gambar yang sudah ada jika ada --}}
                @if($halaman->gambar_unggulan)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $halaman->gambar_unggulan) }}" alt="Gambar Unggulan" class="img-fluid" style="max-height: 150px;">
                    </div>
                @endif
                <div class="form-group">
                    <label>Ganti Gambar</label>
                    <input type="file" name="gambar_unggulan" class="file-upload-default">
                    <div class="input-group col-xs-12">
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

{{-- Letakkan ini di bagian paling bawah file edit.blade.php --}}
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
