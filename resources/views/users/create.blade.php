@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Pengguna Baru</h4>
                <p class="card-description">
                    Buat akun baru dengan peran dan wilayah kerja yang sesuai.
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

                <form class="forms-sample" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    {{-- DATA PENGGUNA UTAMA --}}
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Ulangi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <hr>

                    {{-- PENGATURAN PERAN & WILAYAH --}}
                    <div class="form-group">
                        <label for="role_id">Peran (Role)</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">-- Pilih Peran --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" data-role-name="{{ $role->name }}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kolom Desa (Awalnya disembunyikan) --}}
                    <div class="form-group" id="desa_field" style="display: none;">
                        <label for="desa_id">Tugas di Desa</label>
                        <select class="form-control" id="desa_id" name="desa_id">
                            <option value="">-- Pilih Desa --</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kolom Dusun (Awalnya disembunyikan) --}}
                    <div class="form-group" id="dusun_field" style="display: none;">
                        <label for="dusun_id">Tugas di Dusun</label>
                        <select class="form-control" id="dusun_id" name="dusun_id">
                            <option value="">-- Pilih Dusun --</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan Pengguna</button>
                    <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan/menyembunyikan field wilayah
    function toggleWilayahFields() {
        var selectedRole = $('#role_id').find('option:selected').data('role-name');

        if (selectedRole === 'bidan') {
            $('#desa_field').show();
            $('#dusun_field').hide();
        } else if (selectedRole === 'ketua-posyandu' || selectedRole === 'anggota-posyandu') {
            $('#desa_field').show();
            $('#dusun_field').show();
        } else {
            $('#desa_field').hide();
            $('#dusun_field').hide();
        }
    }

    // Panggil fungsi saat halaman pertama kali dimuat
    toggleWilayahFields();

    // Panggil fungsi setiap kali peran diubah
    $('#role_id').on('change', function() {
        toggleWilayahFields();
    });

    // Fungsi untuk mengambil data dusun saat desa diubah
    $('#desa_id').on('change', function() {
        var desaId = $(this).val();
        var dusunSelect = $('#dusun_id');

        dusunSelect.empty().append('<option value="">-- Memuat Dusun... --</option>');

        if (desaId) {
            $.ajax({
                url: '/api/dusuns/' + desaId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    dusunSelect.empty().append('<option value="">-- Pilih Dusun --</option>');
                    $.each(data, function(key, value) {
                        dusunSelect.append('<option value="' + value.id + '">' + value.nama_dusun + ' (Posyandu: ' + value.nama_posyandu + ')</option>');
                    });
                }
            });
        } else {
            dusunSelect.empty().append('<option value="">-- Pilih Desa Terlebih Dahulu --</option>');
        }
    });
});
</script>
@endsection
