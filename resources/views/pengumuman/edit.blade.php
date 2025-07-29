@extends('layouts.app')

@section('content')

<form class="forms-sample" action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    {{-- KOLOM KIRI --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Pengumuman</h4>
                <p class="card-description">
                    Perbarui detail pengumuman yang akan ditampilkan.
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
                    <label for="judul">Judul Pengumuman</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required>
                </div>

                <div class="form-group">
                    <label for="isi">Isi Pengumuman</label>
                    <textarea class="form-control" id="isi" name="isi" rows="15">{{ old('isi', $pengumuman->isi) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN --}}
    <div class="col-md-4 grid-margin">
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title">Pengaturan</h4>
                <div class="form-group">
                    <label for="tipe">Tipe Tampilan</label>
                    <select class="form-control" id="tipe" name="tipe" required>
                        <option value="info" {{ old('tipe', $pengumuman->tipe) == 'info' ? 'selected' : '' }}>Info Biasa</option>
                        <option value="popup" {{ old('tipe', $pengumuman->tipe) == 'popup' ? 'selected' : '' }}>Pop-up</option>
                        <option value="banner" {{ old('tipe', $pengumuman->tipe) == 'banner' ? 'selected' : '' }}>Banner Atas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai Tampil</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $pengumuman->tanggal_mulai) }}" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai Tampil</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $pengumuman->tanggal_selesai) }}" required>
                </div>
                 <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="published" {{ old('status', $pengumuman->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ old('status', $pengumuman->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lampiran (Opsional)</h4>
                @if($pengumuman->lampiran)
                    <p>File saat ini: <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank">Lihat Lampiran</a></p>
                @endif
                <div class="form-group">
                    <label>Ganti File Lampiran</label>
                    <input type="file" name="lampiran" class="file-upload-default">
                    <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Pilih File...">
                        <span class="input-group-append">
                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti lampiran.</small>
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
    ClassicEditor
        .create( document.querySelector( '#isi' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection
