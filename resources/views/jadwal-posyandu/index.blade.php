@extends('layouts.app')

@section('content')
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
                    <strong>Whoops! Ada yang salah dengan input Anda.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Manajemen Jadwal Kegiatan</h4>
        <div class="d-flex justify-content-between align-items-center">
            <p class="card-description">Kelola semua jadwal kegiatan Posyandu, Posbindu, dll.</p>
            <a href="{{ route('admin.jadwal-posyandu.create') }}" class="btn btn-primary">Tambah Jadwal Baru</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Posyandu</th>
                        <th>Jenis Kegiatan</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwals as $jadwal)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $jadwal->posyandu->nama_posyandu }} <br><small class="text-muted">{{ $jadwal->posyandu->dusun->nama_dusun }}</small></td>
                        <td><span class="badge badge-info">{{ $jadwal->jenis_kegiatan }}</span></td>
                        <td>{{ $jadwal->nama_kegiatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_kegiatan)->format('d M Y') }}</td>
                        <td>{{ $jadwal->waktu_mulai ? \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') : '-' }}</td>
                        {{-- <td>
                            <a href="{{ route('admin.jadwal-posyandu.edit', $jadwal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <button type-="button" class="btn btn-danger btn-sm"
                                data-toggle="modal" data-target="#deleteModal"
                                    data-url="{{ route('admin.jadwal-posyandu.destroy', $jadwal->id) }}">
                                    Hapus
                            </button>
                        </td> --}}
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.jadwal-posyandu.edit', $jadwal->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                        data-toggle="modal" data-target="#deleteModal"
                                            data-url="{{ route('admin.jadwal-posyandu.destroy', $jadwal->id) }}">
                                            Hapus
                                    </button>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada jadwal.</td>
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
