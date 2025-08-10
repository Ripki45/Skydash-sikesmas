@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Posyandu: {{ $posyandu->nama_posyandu }}</h4>
        <form class="forms-sample" action="{{route('admin.posyandu.update', $posyandu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="dusun_id">Pilih Dusun</label>
                <select class="form-control" name="dusun_id" id="dusun_id" required>
                    <option value="">-- Pilih Dusun --</option>
                    @foreach($dusuns as $dusun)
                        <option value="{{ $dusun->id }}" {{ $posyandu->dusun_id == $dusun->id ? 'selected' : '' }}>
                            {{ $dusun->nama_dusun }} (Desa: {{ $dusun->desa->nama_desa }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="nama_posyandu">Nama Posyandu</label>
                <input type="text" class="form-control" id="nama_posyandu" name="nama_posyandu" value="{{ old('nama_posyandu', $posyandu->nama_posyandu) }}" required>
            </div>
            <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
            <a href="{{route('admin.posyandu.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection
