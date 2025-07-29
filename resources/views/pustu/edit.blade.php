@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Data Pustu: {{ $pustu->nama_pustu }}</h4>

                <form class="forms-sample" action="{{ route('pustu.update', $pustu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_pustu">Nama Pustu</label>
                        <input type="text" class="form-control" id="nama_pustu" name="nama_pustu" value="{{ old('nama_pustu', $pustu->nama_pustu) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Photo Saat Ini</label>
                        @if($pustu->photo_pustu)
                        <div>
                            <img src="{{ asset('storage/' . $pustu->photo_pustu) }}" alt="Photo Pustu" class="img-fluid" style="max-width: 300px; border-radius: 5px;">
                        </div>
                        @else
                        <p class="text-muted">Tidak ada foto.</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Ganti Photo Pustu</label>
                        <input type="file" name="photo_pustu" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>

                    <div class="form-group">
                        <label for="tenaga_kesehatan">Tenaga Kesehatan</label>
                        <textarea class="form-control" id="tenaga_kesehatan" name="tenaga_kesehatan" rows="3">{{ old('tenaga_kesehatan', $pustu->tenaga_kesehatan) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required>{{ old('alamat', $pustu->alamat) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="jadwal_layanan">Jadwal Layanan</label>
                        <input type="text" class="form-control" id="jadwal_layanan" name="jadwal_layanan" value="{{ old('jadwal_layanan', $pustu->jadwal_layanan) }}">
                    </div>

                    <div class="form-group">
                        <label for="lokasi_map">Link Lokasi Google Maps</label>
                        <input type="url" class="form-control" id="lokasi_map" name="lokasi_map" value="{{ old('lokasi_map', $pustu->lokasi_map) }}">
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('pustu.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
