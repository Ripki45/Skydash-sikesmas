@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Pengguna: {{ $user->name }}</h4>
        <p class="card-description">Ubah data pengguna di bawah ini.</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- PERBAIKAN #1: Arahkan form ke route 'update' dan gunakan method 'PUT' --}}
        <form class="forms-sample" action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- DATA PENGGUNA --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                {{-- PERBAIKAN #2: Isi 'value' dengan data lama --}}
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Ulangi Password Baru</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <hr>

            {{-- PERAN & WILAYAH --}}
            <div class="form-group">
                <label for="role_name">Peran (Role)</label>
                <select class="form-control" id="role_name" name="role_name" required>
                    <option value="">-- Pilih Peran --</option>
                    @foreach($roles as $role)
                        {{-- PERBAIKAN #3: Tandai 'selected' jika cocok dengan data lama --}}
                        <option value="{{ $role->name }}" {{ old('role_name', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="wilayah-fields" style="display: none;">
                <div class="form-group" id="desa-wrapper">
                    <label for="desa_id">Tugas di Desa</label>
                    <select class="form-control" id="desa_id" name="desa_id">
                        <option value="">-- Pilih Desa --</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ old('desa_id', $user->desa_id) == $desa->id ? 'selected' : '' }}>
                                {{ $desa->nama_desa }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="dusun-wrapper">
                    <label for="dusun_id">Tugas di Dusun</label>
                    <select class="form-control" id="dusun_id" name="dusun_id">
                        {{-- Opsi dusun akan diisi oleh JS, tapi kita tampilkan data lama jika ada --}}
                        @foreach($dusuns as $dusun)
                             <option value="{{ $dusun->id }}" {{ old('dusun_id', $user->dusun_id) == $dusun->id ? 'selected' : '' }}>
                                {{ $dusun->nama_dusun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" id="posyandu-wrapper">
                    <label for="posyandu_id">Tugas di Posyandu</label>
                    <select class="form-control" id="posyandu_id" name="posyandu_id">
                       {{-- Opsi posyandu akan diisi oleh JS, tapi kita tampilkan data lama jika ada --}}
                        @foreach($posyandus as $posyandu)
                             <option value="{{ $posyandu->id }}" {{ old('posyandu_id', $user->posyandu_id) == $posyandu->id ? 'selected' : '' }}>
                                {{ $posyandu->nama_posyandu }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Simpan Perubahan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection

{{-- Kita gunakan JavaScript yang sama persis dengan halaman 'create' --}}
@push('scripts')
    {{-- Salin-tempel seluruh blok <script> dari file create.blade.php ke sini --}}
    <script>
        // KODE JAVASCRIPT DARI HALAMAN CREATE.BLADE.PHP DITEMPEL DI SINI
        $(document).ready(function() {
            const roleSelect = $('#role_name');
            const wilayahFieldsWrapper = $('#wilayah-fields');
            const desaWrapper = $('#desa-wrapper');
            const dusunWrapper = $('#dusun-wrapper');
            const posyanduWrapper = $('#posyandu-wrapper');
            const desaSelect = $('#desa_id');
            const dusunSelect = $('#dusun_id');
            const posyanduSelect = $('#posyandu_id');

            function handleRoleChange() {
                const selectedRole = roleSelect.val();
                const needsDesa = ['Bidan', 'Ketua Posyandu', 'Anggota Posyandu'];
                const needsDusun = ['Ketua Posyandu', 'Anggota Posyandu'];
                const needsPosyandu = ['Ketua Posyandu', 'Anggota Posyandu'];

                wilayahFieldsWrapper.hide();
                desaWrapper.hide();
                dusunWrapper.hide();
                posyanduWrapper.hide();

                if (needsDesa.includes(selectedRole)) {
                    wilayahFieldsWrapper.show();
                    desaWrapper.show();
                }
                if (needsDusun.includes(selectedRole)) {
                    dusunWrapper.show();
                }
                if (needsPosyandu.includes(selectedRole)) {
                    posyanduWrapper.show();
                }
            }

            function fetchDusuns() {
                const desaId = desaSelect.val();
                if (!desaId) {
                    dusunSelect.empty().append('<option value="">-- Pilih Desa Dulu --</option>');
                    posyanduSelect.empty().append('<option value="">-- Pilih Dusun Dulu --</option>');
                    return;
                }
                dusunSelect.empty().append('<option value="">-- Memuat... --</option>');
                $.ajax({
                    url: '{{ route("admin.getDusunsByDesa") }}', type: 'POST',
                    data: { _token: '{{ csrf_token() }}', desa_id: desaId },
                    success: function(data) {
                        dusunSelect.empty().append('<option value="">-- Pilih Dusun --</option>');
                        $.each(data, function(key, value) {
                            dusunSelect.append($('<option>', { value: value.id, text: value.nama_dusun }));
                        });
                    }
                });
            }

            function fetchPosyandus() {
                const dusunId = dusunSelect.val();
                if (!dusunId) {
                    posyanduSelect.empty().append('<option value="">-- Pilih Dusun Dulu --</option>');
                    return;
                }
                posyanduSelect.empty().append('<option value="">-- Memuat... --</option>');
                $.ajax({
                    url: '{{ route("admin.getPosyandusByDusun") }}', type: 'POST',
                    data: { _token: '{{ csrf_token() }}', dusun_id: dusunId },
                    success: function(data) {
                        posyanduSelect.empty().append('<option value="">-- Pilih Posyandu --</option>');
                        $.each(data, function(key, value) {
                            posyanduSelect.append($('<option>', { value: value.id, text: value.nama_posyandu }));
                        });
                    }
                });
            }

            roleSelect.on('change', handleRoleChange);
            desaSelect.on('change', fetchDusuns);
            dusunSelect.on('change', fetchPosyandus);

            // Panggil saat halaman dimuat untuk menampilkan field sesuai data lama
            handleRoleChange();
        });
    </script>
@endpush
