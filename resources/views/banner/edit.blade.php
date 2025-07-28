@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Banner</h4>
                <form class="forms-sample" action="{{ route('banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Gambar Banner Saat Ini</label>
                        <div>
                            <img src="{{ asset('storage/' . $banner->gambar_banner) }}" alt="Banner" class="img-fluid" style="max-width: 300px; border-radius: 5px;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gambar_banner">Ganti Gambar Banner</label>
                        <input type="file" name="gambar_banner" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih Gambar (Max 2MB)...">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    </div>
                    <div class="form-group">
                        <label for="urutan_tampil">Urutan Tampil</label>
                        <input type="number" class="form-control" id="urutan_tampil" name="urutan_tampil" value="{{ old('urutan_tampil', $banner->urutan_tampil) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('banner.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
