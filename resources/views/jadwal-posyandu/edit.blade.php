@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Jadwal</h4>
        <form class="forms-sample" action="{{ route('admin.jadwal-posyandu.update', $jadwalPosyandu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="posyandu_id">Pilih Posyandu</label>
                <select class="form-control" name="posyandu_id" id="posyandu_id" required>
                    @foreach($posyandus as $posyandu)
                        <option value="{{ $posyandu->id }}" {{ $jadwalPosyandu->posyandu_id == $posyandu->id ? 'selected' : '' }}>
                            {{ $posyandu->nama_posyandu }} (Dusun: {{ $posyandu->dusun->nama_dusun }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_kegiatan">Jenis Kegiatan</label>
                <select class="form-control" name="jenis_kegiatan" id="jenis_kegiatan" required>
                    <option value="Posyandu Balita" {{ $jadwalPosyandu->jenis_kegiatan == 'Posyandu Balita' ? 'selected' : '' }}>Posyandu Balita</option>
                    <option value="Posyandu Lansia" {{ $jadwalPosyandu->jenis_kegiatan == 'Posyandu Lansia' ? 'selected' : '' }}>Posyandu Lansia</option>
                    <option value="Posbindu PTM" {{ $jadwalPosyandu->jenis_kegiatan == 'Posbindu PTM' ? 'selected' : '' }}>Posbindu PTM</option>
                    <option value="Posyandu Remaja" {{ $jadwalPosyandu->jenis_kegiatan == 'Posyandu Remaja' ? 'selected' : '' }}>Posyandu Remaja</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_kegiatan">Nama/Tema Kegiatan</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan', $jadwalPosyandu->nama_kegiatan) }}" required>
            </div>
            <div class="form-group">
                <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="{{ old('tanggal_kegiatan', $jadwalPosyandu->tanggal_kegiatan) }}" required>
            </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $jadwalPosyandu->waktu_mulai) }}">
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $jadwalPosyandu->waktu_selesai) }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $jadwalPosyandu->keterangan) }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
            <a href="{{ route('admin.jadwal-posyandu.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection
