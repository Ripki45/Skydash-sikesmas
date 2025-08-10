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
        <div class="d-flex justify-content-between align-items-center">
            <p class="card-description">
                Semua data hasil skrining kesehatan lansia yang telah diinput.
            </p>
            <a href="{{ route('admin.skrining-skilas.create') }}" class="btn btn-primary">Input Skrining Baru</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped" id="skilasTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>NIK Pasien</th>
                        <th>Nama Pasien</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($skriningSkilas as $skrining)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($skrining->tanggal_skrining)->format('d M Y') }}</td>
                            <td>{{ $skrining->nik }}</td>
                            <td>{{ $skrining->nama_lengkap }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.skrining-skilas.show', $skrining->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('admin.skrining-skilas.edit', $skrining->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-toggle="modal" data-target="#deleteModal"
                                            data-url="{{ route('admin.skrining-skilas.destroy', $skrining->id) }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data skrining yang diinput.</td>
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
                Apakah Anda yakin ingin menghapus data skrining ini?
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

@push('scripts')
{{-- PASTIKAN SELURUH BLOK SCRIPT INI ADA --}}
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable
    $('#skilasTable').DataTable({
        "language": {
            "search": "Cari (NIK/Nama):",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_-_END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": { "next": "Berikutnya", "previous": "Sebelumnya" }
        }
    });

    // 2. "KABEL" UNTUK MODAL HAPUS
    // Script ini akan mengawasi klik pada tombol hapus
    $(document).on('click', '.delete-btn', function() {
        // Ambil URL dari tombol yang diklik
        var deleteUrl = $(this).data('url');
        // Atur 'action' dari form di modal menjadi URL tersebut
        $('#deleteForm').attr('action', deleteUrl);
    });
});
</script>
@endpush
