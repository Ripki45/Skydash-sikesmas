@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Layanan Baru</h4>
                <form class="forms-sample" action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nama_layanan">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" placeholder="Contoh: BPJS Kesehatan" required>
                    </div>
                    <div class="form-group">
                        <label for="link">Link Tujuan</label>
                        <input type="url" class="form-control" id="link" name="link" placeholder="https://www.bpjs-kesehatan.go.id" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar/Icon</label>
                        <input type="file" name="gambar_icon" class="file-upload-default" required>
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar/Icon...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="urutan">Urutan</label>
                        <input type="number" class="form-control" id="urutan" name="urutan" value="0" required>
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('admin.layanan.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
