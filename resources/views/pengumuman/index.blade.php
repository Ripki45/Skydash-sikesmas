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

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manajemen Pengumuman</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="card-description">
                        Kelola semua pengumuman (Info, Pop-up, Banner).
                    </p>
                    {{-- Tombol ini akan kita fungsikan nanti --}}
                    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary">Buat Pengumuman Baru</a>
                </div>

                <div class="form-group mt-3">
                    <label for="tipeFilter" class="mr-2">Filter Tipe:</label>
                    <select id="tipeFilter" class="form-control" style="width: 150px; display: inline-block;">
                        <option value="">Semua</option>
                        <option value="info">Info</option>
                        <option value="popup">Pop-up</option>
                        <option value="banner">Banner</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="pengumumanTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                {{-- REVISI #1: Judul kolom diperpendek --}}
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumumans as $pengumuman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengumuman->judul }}</td>
                                    <td><span class="badge badge-info">{{ $pengumuman->tipe }}</span></td>
                                    <td>
                                        @if($pengumuman->status == 'published')
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal_mulai)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pengumuman->tanggal_selesai)->format('d M Y') }}</td>
                                    <td>
                                        {{-- REVISI #2: Tombol dikelompokkan agar lebih rapi --}}
                                        <div class="btn-group" role="group" aria-label="Aksi Pengguna">
                                            <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            {{-- Tambahkan class 'delete-btn' untuk JavaScript --}}
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-url="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        var table = $('#pengumumanTable').DataTable({
            "language": { "search": "Cari:", "lengthMenu": "Tampilkan _MENU_ data", "info": "Menampilkan _START_-_END_ dari _TOTAL_ data", "infoEmpty": "Tidak ada data", "infoFiltered": "(difilter dari _MAX_ total data)", "paginate": { "next": "Berikutnya", "previous": "Sebelumnya" } }
        });

        // Fungsi untuk filter tipe
        $('#tipeFilter').on('change', function(){
            // Kolom ke-2 adalah Tipe (dimulai dari 0)
            table.column(2).search(this.value).draw();
        });
    });
</script>
@endsection
