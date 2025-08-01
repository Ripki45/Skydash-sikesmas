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
        <h4 class="card-title">Manajemen Pengguna</h4>
        <div class="d-flex justify-content-between align-items-center">
            <p class="card-description">Kelola semua akun pengguna sistem.</p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna Baru</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped" id="usersTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Desa</th>
                        <th>Dusun</th>
                        <th>Posyandu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-primary">{{ $role->display_name }}</span>
                                @endforeach
                            </td>
                            {{-- Menampilkan data wilayah kerja dari relasi --}}
                            <td>{{ $user->desa->nama_desa ?? ($user->posyandu->dusun->desa->nama_desa ?? '-') }}</td>
                            <td>{{ $user->dusun->nama_dusun ?? ($user->posyandu->dusun->nama_dusun ?? '-') }}</td>
                            <td>{{ $user->posyandu->nama_posyandu ?? '-' }}</td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type-="button" class="btn btn-danger btn-sm"
                                    data-toggle="modal" data-target="#deleteModal"
                                    data-url="{{ route('users.destroy', $user->id) }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                {{--
                    REVISI PENTING #2: Form Hapus
                    Pastikan form ini ada di dalam file Blade dan memiliki @csrf serta @method('DELETE')
                    Ini adalah penyebab utama error Anda.
                --}}
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

@section('scripts')
<script>
    $(document).ready(function() {
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
</script>
@endsection
