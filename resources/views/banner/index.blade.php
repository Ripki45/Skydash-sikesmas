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
                    <a href="{{ route('banner.create') }}" class="btn btn-primary">Tambah Banner Baru</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    {{-- <td>
                                        <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Hapus</a>
                                    </td> --}}
                                    <td>
                                            <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <button type-="button" class="btn btn-danger btn-sm"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-url="{{ route('banner.destroy', $banner->id) }}">
                                                Hapus
                                            </button>
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
                <form class="forms-sample" action="#" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="teks">Teks Berjalan</label>
                        <textarea class="form-control" name="teks" id="teks" rows="3">{{ $runningText->teks }}</textarea>
                    </div>
                     <div class="form-group">
                        <label for="link">Link (Opsional)</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="https://contoh.com" value="{{ $runningText->link }}">
                    </div>
                     <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="1" {{ $runningText->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$runningText->is_active ? 'selected' : '' }}>Tidak Aktif</option>
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
        $('#deleteModal').on('show.bs.modal', function (event) {
            // ... isi script ...
        });
    });
</script>
@endsection
