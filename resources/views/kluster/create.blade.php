@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Menu Baru</h4>
                <p class="card-description">
                    Isi detail menu untuk navigasi website.
                </p>

                {{-- Menampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="forms-sample" action="{{ route('kluster.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Judul Menu</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Profil" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Menu Induk (Parent)</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($klusters as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih menu induk jika ini adalah sub-menu.</small>
                    </div>

                    <div class="form-group">
                        <label for="halaman_id">Hubungkan ke Halaman</label>
                        <select class="form-control" id="halaman_id" name="halaman_id">
                            <option value="">-- Tidak Dihubungkan --</option>
                             @foreach($halamans as $id => $judul)
                                <option value="{{ $id }}">{{ $judul }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih halaman jika menu ini mengarah ke sebuah halaman.</small>
                    </div>

                     <div class="form-group">
                        <label for="url">Link Manual (URL)</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Contoh: https://google.com" value="{{ old('url') }}">
                        <small class="form-text text-muted">Isi ini jika menu tidak terhubung ke halaman (misal ke website luar).</small>
                    </div>

                    <div class="form-group">
                        <label for="order">Urutan</label>
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', 0) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                    <a href="{{ route('kluster.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
