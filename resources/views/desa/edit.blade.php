@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Desa: {{ $desa->nama_desa }}</h4>

                <form class="forms-sample" action="{{ route('admin.desa.update', $desa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_desa">Nama Desa</label>
                        <input type="text" class="form-control" id="nama_desa" name="nama_desa" value="{{ old('nama_desa', $desa->nama_desa) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('admin.desa.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
