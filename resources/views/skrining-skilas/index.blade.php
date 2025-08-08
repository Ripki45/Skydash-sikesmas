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
        <h4 class="card-title">Data Hasil Skrining SKILAS</h4>
        <div class="d-flex justify-content-between align-items-center">
            <p class="card-description">
                Semua data hasil skrining kesehatan lansia yang telah diinput.
            </p>
            {{-- Tombol ini akan kita fungsikan nanti --}}
            <a href="{{ route('skrining-skilas.create') }}" class="btn btn-primary">Input Skrining Baru</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped" id="skilasTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>NIK Pasien</th>
                        <th>Nama Pasien</th>
                        <th>Usia</th>
                        <th>Diinput Oleh</th>
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
                                {{-- Menghitung usia otomatis dari tanggal lahir --}}
                                {{ \Carbon\Carbon::parse($skrining->tanggal_lahir)->age }} Thn
                            </td>
                            <td>{{ $skrining->user->name }}</td>
                            <td>
                                <a href="{{ route('skrining-skilas.show', $skrining->id) }}" class="btn btn-info btn-sm">Detail</a>
                                {{-- REVISI: Mengarahkan ke route edit --}}
                                <a href="{{ route('skrining-skilas.edit', $skrining->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                {{-- REVISI: Mengaktifkan tombol hapus --}}
                                <button type="button" class="btn btn-danger btn-sm"
                                        data-toggle="modal" data-target="#deleteModal"
                                        data-url="{{ route('skrining-skilas.destroy', $skrining->id) }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data skrining yang diinput.</td>
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

@section('scripts')
{{-- Mengaktifkan DataTables untuk pencarian dan sorting --}}
<script>
    $(document).ready(function() {
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
    });
</script>
@endsection
