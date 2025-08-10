@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="card-title">Manajemen Pengguna</h4>
                <p class="card-description mb-0">Kelola semua akun pengguna sistem.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah Pengguna Baru</a>
        </div>
        <div class="table-responsive mt-4">
            {{-- Ganti ID tabel menjadi #usersTable --}}
            <table class="table table-striped" id="usersTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Ganti variabel menjadi $users dan $user --}}
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    {{-- KOMPONEN #1: TOMBOL PEMICU --}}
                                    {{-- Pastikan rute destroy mengarah ke users.destroy --}}
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-toggle="modal" data-target="#deleteModal"
                                            data-url="{{ route('admin.users.destroy', $user->id) }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data pengguna ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>

                {{-- KOMPONEN #2: MESIN PENGHANCUR (Sudah Benar) --}}
                <form id="deleteForm" action="" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- PASTIKAN KAMU SUDAH MEMUAT JQUERY DI LAYOUT UTAMA SEBELUM @stack('scripts') --}}
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable
    $('#usersTable').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_-_END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": { "next": "Berikutnya", "previous": "Sebelumnya" }
        }
    });
});
$(document).ready(function() {
    // 2. "KABEL" UNIVERSAL UNTUK MODAL HAPUS
    // Script ini akan mengawasi SELURUH halaman untuk klik pada tombol '.delete-btn'
    $(document).on('click', '.delete-btn', function() {
        // Ambil URL dari atribut data-url tombol yang baru saja diklik
        var deleteUrl = $(this).data('url');

        // Atur 'action' dari form di dalam modal menjadi URL tersebut
        $('#deleteForm').attr('action', deleteUrl);
    });
})
</script>
@endpush

