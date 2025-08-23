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
    {{-- BAGIAN UNTUK MANAJEMEN BANNER --}}
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manajemen Banner</h4>
                <p class="card-description">
                    Atur gambar banner yang akan tampil di halaman depan.
                </p>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('admin.banner.create') }}" class="btn btn-primary">Tambah Banner Baru</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="bannerTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gambar Banner</th>
                                <th>Urutan Tampil</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $banner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $banner->gambar_banner) }}" alt="Banner" style="width: 150px; height: auto; border-radius: 5px;">
                                    </td>
                                    <td>{{ $banner->urutan_tampil }}</td>
                                    <td>
                                        <div class="btn-group">
                                            {{-- PERBAIKAN #1: Perbaiki sintaks kurung kurawal --}}
                                            <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                            {{-- PERBAIKAN #2: Arahkan ke rute yang benar (banner.destroy) --}}
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-url="{{ route('admin.banner.destroy', $banner->id) }}">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada banner yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN UNTUK MANAJEMEN RUNNING TEXT --}}
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manajemen Running Text</h4>
                <p class="card-description">
                    Atur teks berjalan yang tampil di bagian atas website.
                </p>
                <form class="forms-sample" action="{{ route('admin.running-text.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="teks">Teks Berjalan</label>
                        <textarea class="form-control" name="teks" id="teks" rows="3">{{ $runningText->teks ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="link">Link (Opsional)</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="https://contoh.com" value="{{ $runningText->link ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1" {{ ($runningText->is_active ?? false) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !($runningText->is_active ?? false) ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Running Text</button>
                </form>
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
                Apakah Anda yakin ingin menghapus banner ini?
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
{{-- PERBAIKAN #3: Tambahkan JQuery sebelum script custom --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi DataTable jika diperlukan
    // Pastikan library DataTable juga sudah dimuat di layout utama
    if ($.fn.DataTable) {
        $('#bannerTable').DataTable();
    }

    // "Kabel" Universal untuk Tombol Hapus
    $(document).on('click', '.delete-btn', function() {
        var deleteUrl = $(this).data('url');
        $('#deleteForm').attr('action', deleteUrl);
    });
});
</script>
@endpush
