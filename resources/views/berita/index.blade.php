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
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Semua Berita</h4>
        <div class="d-flex justify-content-between align-items-center">
            <p class="card-description">Daftar semua berita yang telah dipublikasikan atau disimpan sebagai draft.</p>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">Buat Berita Baru</a>
        </div>

        {{-- Filter --}}
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="kategoriFilter">Filter Kategori:</label>
                    <select id="kategoriFilter" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="statusFilter">Filter Status:</label>
                    <select id="statusFilter" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-2">
            <table class="table table-striped" id="beritaTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Status</th>
                        <th>Tgl Publikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($beritas as $berita)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" alt="{{ $berita->judul }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;"></td>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ $berita->kategori->nama_kategori }}</td>
                            <td>{{ $berita->user->name }}</td>
                            <td>
                                @if($berita->status == 'published')
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-warning">Draft</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($berita->published_at)->format('d M Y') }}</td>
                            {{-- <td>
                                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm"
                                        data-toggle="modal" data-target="#deleteModal"
                                        data-url="{{ route('admin.berita.destroy', $berita->id) }}">
                                    Hapus
                                </button>
                            </td> --}}
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn"
                                            data-toggle="modal" data-target="#deleteModal"
                                                data-url="{{ route('admin.berita.destroy', $berita->id) }}">
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
        var table = $('#beritaTable').DataTable({
            "language": { "search": "Cari Judul/Penulis:", "lengthMenu": "Tampilkan _MENU_ data", "info": "Menampilkan _START_-_END_ dari _TOTAL_ data", "infoEmpty": "Tidak ada data", "infoFiltered": "(difilter dari _MAX_ total data)", "paginate": { "next": "Berikutnya", "previous": "Sebelumnya" } }
        });

        // Filter untuk Kategori (kolom ke-3)
        $('#kategoriFilter').on('change', function(){
            table.column(3).search(this.value).draw();
        });

        // Filter untuk Status (kolom ke-5)
        $('#statusFilter').on('change', function(){
            table.column(5).search(this.value).draw();
        });
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            $('#deleteForm').attr('action', url);
        });
    });
</script>
@endsection
