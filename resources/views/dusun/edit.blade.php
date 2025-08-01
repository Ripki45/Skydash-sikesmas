@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Dusun: {{ $dusun->nama_dusun }}</h4>
                <form class="forms-sample" action="{{ route('dusun.update', $dusun->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="desa_id">Pilih Desa Induk</label>
                        <select class="form-control" name="desa_id" id="desa_id" required>
                            <option value="">-- Pilih Desa --</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}" {{ $dusun->desa_id == $desa->id ? 'selected' : '' }}>
                                    {{ $desa->nama_desa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_dusun">Nama Dusun</label>
                        <input type="text" class="form-control" id="nama_dusun" name="nama_dusun" value="{{ old('nama_dusun', $dusun->nama_dusun) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('dusun.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
