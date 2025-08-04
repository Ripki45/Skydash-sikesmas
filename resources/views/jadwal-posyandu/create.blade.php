@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Jadwal Baru</h4>
        <form class="forms-sample" action="{{ route('jadwal-posyandu.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="posyandu_id">Pilih Posyandu</label>
                <select class="form-control" name="posyandu_id" id="posyandu_id" required>
                    <option value="">-- Pilih Posyandu --</option>
                    @foreach($posyandus as $posyandu)
                        <option value="{{ $posyandu->id }}">{{ $posyandu->nama_posyandu }} (Dusun: {{ $posyandu->dusun->nama_dusun }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_kegiatan">Jenis Kegiatan</label>
                <select class="form-control" name="jenis_kegiatan" id="jenis_kegiatan" required>
                    <option value="Posyandu Balita">Posyandu Balita</option>
                    <option value="Posyandu Lansia">Posyandu Lansia</option>
                    <option value="Posbindu PTM">Posbindu PTM</option>
                    <option value="Posyandu Remaja">Posyandu Remaja</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_kegiatan">Nama/Tema Kegiatan</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" placeholder="Contoh: Penimbangan Rutin & PMT" required>
            </div>
            <div class="form-group">
                <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" required>
            </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai (Opsional)</label>
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai">
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai (Opsional)</label>
                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
            <a href="{{ route('jadwal-posyandu.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection
