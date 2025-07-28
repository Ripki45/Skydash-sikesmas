@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{-- Judul halaman dibuat dinamis sesuai dengan data yang diedit --}}
                <h4 class="card-title">Edit Menu: {{ $kluster->title }}</h4>
                <p class="card-description">
                    Perbarui detail menu untuk navigasi website.
                </p>

                {{-- Blok untuk menampilkan error validasi jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{--
                  Form diarahkan ke route 'kluster.update' dengan mengirimkan ID kluster.
                  Methodnya POST, tetapi di dalamnya kita tambahkan @method('PUT')
                  agar Laravel tahu ini adalah proses UPDATE.
                --}}
                <form class="forms-sample" action="{{ route('kluster.update', $kluster->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Judul Menu</label>
                        {{--
                          'value' diisi dengan old('title') terlebih dahulu. Jika tidak ada (bukan dari error validasi),
                          maka diisi dengan nilai yang sudah ada di database ($kluster->title).
                        --}}
                        <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Profil" value="{{ old('title', $kluster->title) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Menu Induk (Parent)</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($klusters as $id => $title)
                                {{--
                                  Logika untuk memilih opsi yang sudah tersimpan.
                                  Jika ID kluster dari loop sama dengan parent_id dari data yang diedit,
                                  maka tambahkan atribut 'selected'.
                                --}}
                                <option value="{{ $id }}" {{ old('parent_id', $kluster->parent_id) == $id ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih menu induk jika ini adalah sub-menu.</small>
                    </div>

                    <div class="form-group">
                        <label for="halaman_id">Hubungkan ke Halaman</label>
                        <select class="form-control" id="halaman_id" name="halaman_id">
                            <option value="">-- Tidak Dihubungkan --</option>
                             @foreach($halamans as $id => $judul)
                                {{-- Logika 'selected' yang sama diterapkan di sini --}}
                                <option value="{{ $id }}" {{ old('halaman_id', $kluster->halaman_id) == $id ? 'selected' : '' }}>
                                    {{ $judul }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Pilih halaman jika menu ini mengarah ke sebuah halaman.</small>
                    </div>

                     <div class="form-group">
                        <label for="url">Link Manual (URL)</label>
                        {{-- 'value' diisi dengan data yang sudah ada --}}
                        <input type="text" class="form-control" id="url" name="url" placeholder="Contoh: https://google.com" value="{{ old('url', $kluster->url) }}">
                        <small class="form-text text-muted">Isi ini jika menu tidak terhubung ke halaman (misal ke website luar).</small>
                    </div>

                    <div class="form-group">
                        <label for="order">Urutan</label>
                        {{-- 'value' diisi dengan data yang sudah ada --}}
                        <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $kluster->order) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('kluster.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
