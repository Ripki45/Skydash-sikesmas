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

        <form class="forms-sample" action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            {{-- DATA PENGGUNA --}}
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

            {{-- PERAN & WILAYAH --}}
            <div class="form-group">
                <label for="role_name">Peran (Role)</label>
                <select class="form-control" id="role_name" name="role_name" required>
                    <option value="">-- Pilih Peran --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role_name') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Wrapper untuk field wilayah --}}
            <div id="wilayah-fields" style="display: none;">
                <div class="form-group" id="desa-wrapper">
                    <label for="desa_id">Tugas di Desa</label>
                    <select class="form-control" id="desa_id" name="desa_id">
                        <option value="">-- Pilih Desa --</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ old('desa_id') == $desa->id ? 'selected' : '' }}>
                                {{ $desa->nama_desa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="dusun-wrapper">
                    <label for="dusun_id">Tugas di Dusun</label>
                    <select class="form-control" id="dusun_id" name="dusun_id">
                        <option value="">-- Pilih Desa Terlebih Dahulu --</option>
                    </select>
                </div>

                <div class="form-group" id="posyandu-wrapper">
                    <label for="posyandu_id">Tugas di Posyandu</label>
                    <select class="form-control" id="posyandu_id" name="posyandu_id">
                        <option value="">-- Pilih Dusun Terlebih Dahulu --</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Simpan Pengguna</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Normalisasi nama role: lowercase & hapus spasi/underscore/dash
    function normalizeRole(role) {
        return role.toLowerCase().replace(/[_\-]/g, ' ').trim();
    }

    // Handle perubahan role
    function handleRoleChange() {
        var selectedRole = normalizeRole($('#role_name').val() || '');
        console.log("Role terpilih:", selectedRole); // Debug

        var wilayahFields = $('#wilayah-fields');
        var desaWrapper = $('#desa-wrapper');
        var dusunWrapper = $('#dusun-wrapper');
        var posyanduWrapper = $('#posyandu-wrapper');

        // Sembunyikan semua dulu
        wilayahFields.hide();
        desaWrapper.hide();
        dusunWrapper.hide();
        posyanduWrapper.hide();

        // Role yang hanya butuh desa
        if (['bidan', 'ketua posyandu', 'anggota posyandu'].includes(selectedRole)) {
            wilayahFields.slideDown();
            desaWrapper.slideDown();
        }

        // Role yang butuh desa, dusun, posyandu
        if (['ketua posyandu', 'anggota posyandu'].includes(selectedRole)) {
            dusunWrapper.slideDown();
            posyanduWrapper.slideDown();
        }
    }

    // Fetch dusun by desa
    function fetchDusuns() {
        var desaId = $('#desa_id').val();
        var dusunSelect = $('#dusun_id');

        dusunSelect.empty().append('<option value="">-- Memuat... --</option>');
        $('#posyandu_id').empty().append('<option value="">-- Pilih Dusun Dulu --</option>');

        if (!desaId) {
            dusunSelect.empty().append('<option value="">-- Pilih Desa Dulu --</option>');
            return;
        }

        $.ajax({
            url: '{{ route("admin.getDusunsByDesa") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                desa_id: desaId
            },
            success: function(data) {
                dusunSelect.empty().append('<option value="">-- Pilih Dusun --</option>');
                $.each(data, function(key, value) {
                    dusunSelect.append('<option value="' + value.id + '">' + value.nama_dusun + '</option>');
                });
            }
        });
    }

    // Fetch posyandu by dusun
    function fetchPosyandus() {
        var dusunId = $('#dusun_id').val();
        var posyanduSelect = $('#posyandu_id');

        posyanduSelect.empty().append('<option value="">-- Memuat... --</option>');

        if (!dusunId) {
            posyanduSelect.empty().append('<option value="">-- Pilih Dusun Dulu --</option>');
            return;
        }

        $.ajax({
            url: '{{ route("admin.getPosyandusByDusun") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                dusun_id: dusunId
            },
            success: function(data) {
                posyanduSelect.empty().append('<option value="">-- Pilih Posyandu --</option>');
                $.each(data, function(key, value) {
                    posyanduSelect.append('<option value="' + value.id + '">' + value.nama_posyandu + '</option>');
                });
            }
        });
    }

    // Event listeners
    $('#role_name').on('change', handleRoleChange);
    $('#desa_id').on('change', fetchDusuns);
    $('#dusun_id').on('change', fetchPosyandus);

    // Jalankan saat halaman pertama kali load
    handleRoleChange();
});
</script>
@endpush
