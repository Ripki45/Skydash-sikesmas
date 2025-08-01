@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Pengguna: {{ $user->name }}</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="forms-sample" action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            {{-- DATA PENGGUNA --}}
            <div class="form-group"><label for="name">Nama Lengkap</label><input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required></div>
            <div class="form-group"><label for="email">Email</label><input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required></div>
            <div class="form-group"><label for="password">Password Baru (Opsional)</label><input type="password" class="form-control" id="password" name="password"><small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small></div>
            <div class="form-group"><label for="password_confirmation">Ulangi Password Baru</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation"></div>
            <hr>

            {{-- PERAN & WILAYAH --}}
            <div class="form-group">
                <label for="role_id">Peran (Role)</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" data-role-name="{{ $role->name }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                            {{ $role->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="desa_field" style="display: none;">
                <label for="desa_id">Tugas di Desa</label>
                <select class="form-control" id="desa_id" name="desa_id" data-url="{{ route('api.dusuns.by.desa', ['desa' => 'PLACEHOLDER']) }}">
                    <option value="">-- Pilih Desa --</option>
                    @foreach($desas as $desa)
                        <option value="{{ $desa->id }}" {{ old('desa_id', $user->desa_id) == $desa->id ? 'selected' : '' }}>
                            {{ $desa->nama_desa }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="dusun_field" style="display: none;">
                <label for="dusun_id">Tugas di Dusun</label>
                <select class="form-control" id="dusun_id" name="dusun_id" data-url="{{ route('api.posyandus.by.dusun', ['dusun' => 'PLACEHOLDER']) }}">
                    <option value="">-- Pilih Desa Terlebih Dahulu --</option>
                    @foreach($dusuns as $dusun)
                        <option value="{{ $dusun->id }}" {{ old('dusun_id', $user->dusun_id) == $dusun->id ? 'selected' : '' }}>
                            {{ $dusun->nama_dusun }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="posyandu_field" style="display: none;">
                <label for="posyandu_id">Tugas di Posyandu</label>
                <select class="form-control" id="posyandu_id" name="posyandu_id">
                    <option value="">-- Pilih Dusun Terlebih Dahulu --</option>
                     @foreach($posyandus as $posyandu)
                        <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $user->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                            {{ $posyandu->nama_posyandu }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
            <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Fungsi untuk menampilkan/menyembunyikan field wilayah
    function toggleWilayahFields() {
        var selectedRole = $('#role_id').find('option:selected').data('role-name');
        $('#desa_field, #dusun_field, #posyandu_field').slideUp();
        if (selectedRole === 'bidan') {
            $('#desa_field').slideDown();
        } else if (selectedRole === 'ketua-posyandu' || selectedRole === 'anggota-posyandu') {
            $('#desa_field').slideDown();
            $('#dusun_field').slideDown();
            $('#posyandu_field').slideDown();
        }
    }

    $('#role_id').on('change', toggleWilayahFields);
    // Jalankan saat halaman dimuat untuk menyesuaikan field dengan role yang sudah ada
    toggleWilayahFields();

    // Fungsi untuk memuat dusun berdasarkan desa
    $('#desa_id').on('change', function() {
        var desaId = $(this).val();
        var dusunSelect = $('#dusun_id');
        var url = $(this).data('url').replace('PLACEHOLDER', desaId);

        dusunSelect.empty().append('<option value="">-- Memuat... --</option>');
        $('#posyandu_id').empty().append('<option value="">-- Pilih Dusun Dulu --</option>');

        if (desaId) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    dusunSelect.empty().append('<option value="">-- Pilih Dusun --</option>');
                    $.each(data, function(key, value) {
                        dusunSelect.append('<option value="' + value.id + '">' + value.nama_dusun + '</option>');
                    });
                }
            });
        } else {
            dusunSelect.empty().append('<option value="">-- Pilih Desa Dulu --</option>');
        }
    });

    // Fungsi untuk memuat posyandu berdasarkan dusun
    $('#dusun_id').on('change', function() {
        var dusunId = $(this).val();
        var posyanduSelect = $('#posyandu_id');
        var url = $(this).data('url').replace('PLACEHOLDER', dusunId);

        posyanduSelect.empty().append('<option value="">-- Memuat... --</option>');

        if (dusunId) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    posyanduSelect.empty().append('<option value="">-- Pilih Posyandu --</option>');
                    $.each(data, function(key, value) {
                        posyanduSelect.append('<option value="' + value.id + '">' + value.nama_posyandu + '</option>');
                    });
                }
            });
        } else {
            posyanduSelect.empty().append('<option value="">-- Pilih Dusun Dulu --</option>');
        }
    });
});
</script>
@endsection
