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

{{-- PERBAIKAN #1: Tambahkan @method('PUT') untuk rute resource update --}}
<form action="{{ route('admin.settings.update', ['setting' => 1]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- KOLOM KIRI --}}
        <div class="col-md-8">
            {{-- Card Informasi Umum --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">Informasi Umum</h4>
                    <div class="form-group">
                        <label for="nama_puskesmas">Nama Puskesmas</label>
                        <input type="text" class="form-control" name="nama_puskesmas" id="nama_puskesmas" value="{{ $settings['nama_puskesmas'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="kecamatan">Kecamatan</label>
                        <input type="text" class="form-control" name="kecamatan" id="kecamatan" value="{{ $settings['kecamatan'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Singkat (Tentang Kami)</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5">{{ $settings['deskripsi'] ?? '' }}</textarea>
                    </div>
                     <div class="form-group">
                        <label for="kepala_puskesmas">Kepala Puskesmas</label>
                        <input type="text" class="form-control" name="kepala_puskesmas" id="kepala_puskesmas" value="{{ $settings['kepala_puskesmas'] ?? '' }}">
                    </div>
                     <div class="form-group">
                        <label for="alamat_lengkap">Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat_lengkap" id="alamat_lengkap" rows="3">{{ $settings['alamat_lengkap'] ?? '' }}</textarea>
                    </div>
                     <div class="form-group">
                        <label for="legalitas_sk">Legalitas / SK</label>
                        <input type="text" class="form-control" name="legalitas_sk" id="legalitas_sk" value="{{ $settings['legalitas_sk'] ?? '' }}">
                    </div>
                </div>
            </div>

            {{-- Card Visi & Misi --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Visi & Misi</h4>
                    <div class="form-group">
                        <label for="visi">Visi</label>
                        <textarea class="form-control" name="visi" id="visi" rows="3">{{ $settings['visi'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="misi">Misi</label>
                        <textarea class="form-control" name="misi" id="misi" rows="6" placeholder="Gunakan bullet point atau daftar bernomor">{{ $settings['misi'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-md-4">
            {{-- Card Logo & Foto --}}
            <div class="card mb-4">
                <div class="card-body">
                     <div class="form-group">
                        <label>Logo Puskesmas</label>
                        @if(isset($settings['logo_puskesmas']))
                            <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" class="img-fluid mb-2" style="max-height: 100px;">
                        @endif
                        <input type="file" name="logo_puskesmas" class="file-upload-default">
                        <div class="input-group">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Ganti Logo...">
                            <span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button">Upload</button></span>
                        </div>
                    </div>
                    <hr>
                     <div class="form-group">
                        <label>Foto Gedung Puskesmas</label>
                         @if(isset($settings['foto_puskesmas']))
                            <img src="{{ asset('storage/' . $settings['foto_puskesmas']) }}" class="img-fluid mb-2" style="max-height: 150px;">
                        @endif
                        <input type="file" name="foto_puskesmas" class="file-upload-default">
                        <div class="input-group">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Ganti Foto...">
                            <span class="input-group-append"><button class="file-upload-browse btn btn-primary" type="button">Upload</button></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Kontak & Media Sosial --}}
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Kontak & Media Sosial</h4>
                     <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $settings['email'] ?? '' }}">
                    </div>
                     <div class="form-group">
                        <label for="telepon">Telepon / WhatsApp</label>
                        <input type="text" class="form-control" name="telepon" id="telepon" value="{{ $settings['telepon'] ?? '' }}">
                    </div>
                     <div class="form-group">
                        <label for="lokasi_gmaps">Link Google Maps</label>
                        <input type="url" class="form-control" name="lokasi_gmaps" id="lokasi_gmaps" value="{{ $settings['lokasi_gmaps'] ?? '' }}">
                    </div>
                    <hr>
                     <div class="form-group">
                        <label for="sosmed_facebook">Facebook URL</label>
                        <input type="url" class="form-control" name="sosmed_facebook" id="sosmed_facebook" value="{{ $settings['sosmed_facebook'] ?? '' }}">
                    </div>
                     <div class="form-group">
                        <label for="sosmed_instagram">Instagram URL</label>
                        <input type="url" class="form-control" name="sosmed_instagram" id="sosmed_instagram" value="{{ $settings['sosmed_instagram'] ?? '' }}">
                    </div>
                     <div class="form-group">
                        <label for="sosmed_tiktok">TikTok URL</label>
                        <input type="url" class="form-control" name="sosmed_tiktok" id="sosmed_tiktok" value="{{ $settings['sosmed_tiktok'] ?? '' }}">
                    </div>
                     <div class="form-group">
                        <label for="sosmed_youtube">Youtube URL</label>
                        <input type="url" class="form-control" name="sosmed_youtube" id="sosmed_youtube" value="{{ $settings['sosmed_youtube'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg">Simpan Semua Perubahan</button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
{{-- PERBAIKAN #2: Tambahkan CKEditor & script file upload --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    // Inisialisasi CKEditor untuk textarea yang lebih kompleks
    ClassicEditor.create( document.querySelector( '#deskripsi' ) ).catch( error => console.error( error ) );
    ClassicEditor.create( document.querySelector( '#visi' ) ).catch( error => console.error( error ) );
    ClassicEditor.create( document.querySelector( '#misi' ) ).catch( error => console.error( error ) );
</script>
@endpush
