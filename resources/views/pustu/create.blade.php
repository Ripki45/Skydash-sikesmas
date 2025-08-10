@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Data Puskesmas Pembantu (Pustu)</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="forms-sample" action="{{ route('admin.pustu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_pustu">Nama Pustu</label>
                        <input type="text" class="form-control" id="nama_pustu" name="nama_pustu" value="{{ old('nama_pustu') }}" placeholder="Contoh: Pustu Desa Cigugur" required>
                    </div>

                    <div class="form-group">
                        <label>Photo Pustu</label>
                        <input type="file" name="photo_pustu" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tenaga_kesehatan">Tenaga Kesehatan</label>
                        <textarea class="form-control" id="tenaga_kesehatan" name="tenaga_kesehatan" rows="3" placeholder="Contoh: Bidan Yanti, Perawat Budi">{{ old('tenaga_kesehatan') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="jadwal_layanan">Jadwal Layanan</label>
                        <input type="text" class="form-control" id="jadwal_layanan" name="jadwal_layanan" value="{{ old('jadwal_layanan') }}" placeholder="Contoh: Senin - Jumat, 08:00 - 15:00">
                    </div>

                    <div class="form-group">
                        <label for="lokasi_map">Link Lokasi Google Maps</label>
                        <input type="url" class="form-control" id="lokasi_map" name="lokasi_map" value="{{ old('lokasi_map') }}" placeholder="https://maps.app.goo.gl/contohlink">
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('admin.pustu.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
