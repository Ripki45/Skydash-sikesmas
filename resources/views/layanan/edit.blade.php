@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Layanan: {{ $layanan->nama_layanan }}</h4>
                <form class="forms-sample" action="{{ route('layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_layanan">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="link">Link Tujuan</label>
                        <input type="url" class="form-control" id="link" name="link" value="{{ old('link', $layanan->link) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar/Icon Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $layanan->gambar_icon) }}" alt="Icon" class="img-fluid" style="max-width: 100px; border-radius: 5px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ganti Gambar/Icon</label>
                        <input type="file" name="gambar_icon" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar/Icon...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>
                    <div class="form-group">
                        <label for="urutan">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="{{ old('urutan', $layanan->urutan) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1" {{ old('is_active', $layanan->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $layanan->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('layanan.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

