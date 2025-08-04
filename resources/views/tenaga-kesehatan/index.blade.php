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
        <h4 class="card-title">Manajemen Sumber Daya Manusia (SDM)</h4>
        <div class="d-flex justify-content-between align-items-center">
            <p class="card-description">Kelola data semua tenaga kesehatan dan staf.</p>
            <a href="{{ route('tenaga-kesehatan.create') }}" class="btn btn-primary">Tambah Data Baru</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>NIP/NIK</th>
                        <th>Jabatan</th>
                        <th>Jadwal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tenagaKesehatans as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://via.placeholder.com/80x80.png?text=No+Photo' }}" alt="{{ $item->nama_lengkap }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                        </td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->nip_nik ?? '-' }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->jadwal_praktik ?? '-' }}</td>
                        <td>
                        <a href="{{ route('tenaga-kesehatan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button type-="button" class="btn btn-danger btn-sm"
                            data-toggle="modal" data-target="#deleteModal"
                                data-url="{{ route('tenaga-kesehatan.destroy', $item->id) }}">
                                Hapus
                        </button>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data SDM.</td>
                    </tr>
                    @endforelse
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
                Apakah Anda yakin ingin menghapus halaman ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
