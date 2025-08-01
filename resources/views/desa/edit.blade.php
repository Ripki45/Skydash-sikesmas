@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Pengguna: {{ $user->name }}</h4>

                <form class="forms-sample" action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- DATA PENGGUNA UTAMA --}}
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru (Opsional)</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Ulangi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <hr>

                    {{-- PENGATURAN PERAN & WILAYAH --}}
                    <div class="form-group">
                        <label for="role_id">Peran (Role)</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">-- Pilih Peran --</option>
                            @foreach($roles as $role)
                                {{-- 'hasRole' akan kita buat nanti, untuk sekarang gunakan 'contains' --}}
                                <option value="{{ $role->id }}" data-role-name="{{ $role->name }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="desa_field" style="display: none;">
                        <label for="desa_id">Tugas di Desa</label>
                        <select class="form-control" id="desa_id" name="desa_id">
                            <option value="">-- Pilih Desa --</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}" {{ $user->desa_id == $desa->id ? 'selected' : '' }}>
                                    {{ $desa->nama_desa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="dusun_field" style="display: none;">
                        <label for="dusun_id">Tugas di Dusun</label>
                        <select class="form-control" id="dusun_id" name="dusun_id">
                            <option value="">-- Pilih Desa Terlebih Dahulu --</option>
                            @foreach($dusuns as $dusun)
                                <option value="{{ $dusun->id }}" {{ $user->dusun_id == $dusun->id ? 'selected' : '' }}>
                                    {{ $dusun->nama_dusun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- JavaScript "Ajaib" yang sama seperti di create.blade.php --}}
<script>
$(document).ready(function() {
    function toggleWilayahFields() {
        var selectedRole = $('#role_id').find('option:selected').data('role-name');
        if (selectedRole === 'bidan') {
            $('#desa_field').slideDown();
            $('#dusun_field').slideUp();
        } else if (selectedRole === 'ketua-posyandu' || selectedRole === 'anggota-posyandu') {
            $('#desa_field').slideDown();
            $('#dusun_field').slideDown();
        } else {
            $('#desa_field').slideUp();
            $('#dusun_field').slideUp();
        }
    }

    $('#role_id').on('change', toggleWilayahFields);
    toggleWilayahFields();

    $('#desa_id').on('change', function() {
        var desaId = $(this).val();
        var dusunSelect = $('#dusun_id');
        dusunSelect.empty().append('<option value="">-- Memuat... --</option>');
        if (desaId) {
            $.ajax({
                url: '/api/dusuns/' + desaId,
                type: 'GET',
                dataType: 'json',
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

    // Pemicu awal untuk mengisi dropdown dusun jika desa sudah terpilih saat halaman edit dimuat
    if ($('#desa_id').val()) {
        $('#desa_id').trigger('change');
    }
});
</script>
@endsection
