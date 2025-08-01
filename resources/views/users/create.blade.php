@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Pengguna Baru</h4>
        <p class="card-description">Buat akun baru dengan peran dan wilayah kerja yang sesuai.</p>

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
            {{-- DATA PENGGUNA --}}
            <div class="form-group"><label for="name">Nama Lengkap</label><input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required></div>
            <div class="form-group"><label for="email">Email</label><input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required></div>
            <div class="form-group"><label for="password">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
            <div class="form-group"><label for="password_confirmation">Ulangi Password</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required></div>
            <hr>

            {{-- PERAN & WILAYAH --}}
            <div class="form-group">
                <label for="role_id">Peran (Role)</label>
                <select class="form-control" id="role_id" name="role_id" required>
                    <option value="">-- Pilih Peran --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" data-role-name="{{ $role->name }}">{{ $role->display_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- REVISI #1: Tambahkan data-url di dropdown Desa --}}
            <div class="form-group" id="desa_field" style="display: none;">
                <label for="desa_id">Tugas di Desa</label>
                <select class="form-control" id="desa_id" name="desa_id" data-url="{{ route('api.dusuns.by.desa', ['desa' => 'PLACEHOLDER']) }}">
                    <option value="">-- Pilih Desa --</option>
                    @foreach($desas as $desa)
                        <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                    @endforeach
                </select>
            </div>

            {{-- REVISI #2: Tambahkan data-url di dropdown Dusun --}}
            <div class="form-group" id="dusun_field" style="display: none;">
                <label for="dusun_id">Tugas di Dusun</label>
                <select class="form-control" id="dusun_id" name="dusun_id" data-url="{{ route('api.posyandus.by.dusun', ['dusun' => 'PLACEHOLDER']) }}">
                    <option value="">-- Pilih Desa Terlebih Dahulu --</option>
                </select>
            </div>

            <div class="form-group" id="posyandu_field" style="display: none;">
                <label for="posyandu_id">Tugas di Posyandu</label>
                <select class="form-control" id="posyandu_id" name="posyandu_id">
                    <option value="">-- Pilih Dusun Terlebih Dahulu --</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Simpan Pengguna</button>
            <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection

@section('scripts')
{{-- REVISI #3: Perbarui JavaScript untuk menggunakan data-url --}}
<script>
$(document).ready(function() {
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
    toggleWilayahFields();

    $('#desa_id').on('change', function() {
        var desaId = $(this).val();
        var dusunSelect = $('#dusun_id');
        // Ambil URL dasar dari atribut data-url dan ganti placeholder
        var url = $(this).data('url').replace('PLACEHOLDER', desaId);

        dusunSelect.empty().append('<option value="">-- Memuat... --</option>');
        $('#posyandu_id').empty().append('<option value="">-- Pilih Dusun Dulu --</option>');

        if (desaId) {
            $.ajax({
                url: url, // Gunakan URL yang sudah benar
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

    $('#dusun_id').on('change', function() {
        var dusunId = $(this).val();
        var posyanduSelect = $('#posyandu_id');
        // Ambil URL dasar dari atribut data-url dan ganti placeholder
        var url = $(this).data('url').replace('PLACEHOLDER', dusunId);

        posyanduSelect.empty().append('<option value="">-- Memuat... --</option>');

        if (dusunId) {
            $.ajax({
                url: url, // Gunakan URL yang sudah benar
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
