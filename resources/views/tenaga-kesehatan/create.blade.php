@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Data SDM Baru</h4>
        <form class="forms-sample" action="{{ route('admin.tenaga-kesehatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
            </div>
            <div class="form-group">
                <label for="nip_nik">NIP / NIK (Opsional)</label>
                <input type="text" class="form-control" id="nip_nik" name="nip_nik" value="{{ old('nip_nik') }}">
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan / Profesi</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Bidan, Dokter Umum, Perawat" required>
            </div>
            <div class="form-group">
                <label for="spesialisasi">Spesialisasi (Opsional)</label>
                <input type="text" class="form-control" id="spesialisasi" name="spesialisasi" value="{{ old('spesialisasi') }}" placeholder="Contoh: Gigi, Anak">
            </div>
            <div class="form-group">
                <label for="jadwal_praktik">Jadwal Praktik (Opsional)</label>
                <textarea class="form-control" id="jadwal_praktik" name="jadwal_praktik" rows="3">{{ old('jadwal_praktik') }}</textarea>
            </div>
            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="file-upload-default">
                <div class="input-group">
                    <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Foto...">
                    <span class="input-group-append">
                        <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
            <a href="{{ route('admin.tenaga-kesehatan.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection
