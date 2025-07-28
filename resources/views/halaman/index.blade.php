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
                <h4 class="card-title">Manajemen Halaman</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <p class="card-description">
                        Kelola semua halaman konten dinamis untuk website Anda.
                    </p>
                    <a href="{{ route('halaman.create') }}" class="btn btn-primary">Buat Halaman Baru</a>
                </div>

                {{-- REVISI #1: Menambahkan Dropdown untuk Filter Status --}}
                <div class="form-group mt-3">
                    <label for="statusFilter" class="mr-2">Filter Status:</label>
                    <select id="statusFilter" class="form-control" style="width: 150px; display: inline-block;">
                        <option value="">Semua</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>

                <div class="table-responsive">
                    {{-- REVISI #2: Menambahkan ID pada Tabel --}}
                    <table class="table table-striped" id="halamanTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($halamans as $halaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $halaman->judul }}</td>
                                    <td>
                                        @if($halaman->status == 'published')
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $halaman->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('halaman.show', $halaman->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('halaman.edit', $halaman->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        {{-- Tombol Hapus Baru --}}
                                        <button type="button" class="btn btn-danger btn-sm"
                                                data-toggle="modal"
                                                data-target="#deleteModal"
                                                data-url="{{ route('halaman.destroy', $halaman->id) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada halaman yang dibuat.</td>
                                </tr>
                            @endforelse
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
{{-- REVISI #3: Menambahkan JavaScript untuk DataTables --}}
<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        var table = $('#halamanTable').DataTable({
            // "dom": '<"..."lfrtip>', // Mengatur posisi elemen (opsional)
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Tidak ada data yang cocok",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "paginate": {
                    "first":      "Pertama",
                    "last":       "Terakhir",
                    "next":       "Berikutnya",
                    "previous":   "Sebelumnya"
                },
            }
        });

        // Fungsi untuk filter status
        $('#statusFilter').on('change', function(){
            // Kolom ke-2 adalah Status (dimulai dari 0)
            table.column(2).search(this.value).draw();
        });
    });
</script>
@endsection



@section('scripts')
<script>
    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function (event) {
            // ... isi script ...
        });
    });
</script>
@endsection
