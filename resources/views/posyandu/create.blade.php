@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Posyandu Baru</h4>
        <form class="forms-sample" action="{{ route('posyandu.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="dusun_id">Pilih Dusun</label>
                <select class="form-control" name="dusun_id" id="dusun_id" required>
                    <option value="">-- Pilih Dusun --</option>
                    @foreach($dusuns as $dusun)
                        <option value="{{ $dusun->id }}">{{ $dusun->nama_dusun }} (Desa: {{ $dusun->desa->nama_desa }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_posyandu">Nama Posyandu</label>
                <input type="text" class="form-control" id="nama_posyandu" name="nama_posyandu" placeholder="Contoh: Posyandu Melati 1" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
            <a href="{{ route('posyandu.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection
