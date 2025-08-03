@extends('layouts.app')

@section('content')

{{-- Menampilkan notifikasi sukses dengan tombol close --}}
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
                <h4 class="card-title">Manajemen Kluster (Menu)</h4>
                <p class="card-description">
                    Atur semua menu yang akan ditampilkan di halaman depan website.
                </p>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('kluster.create') }}" class="btn btn-primary">Tambah Menu Baru</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                {{-- Kita hapus kolom "No." karena penomoran menjadi rumit dengan sistem bertingkat --}}
                                <th>Nama Menu/Sub-Menu</th>
                                <th>Terhubung Ke</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($klusters as $kluster)
                                {{-- Panggil "template mini" untuk setiap menu level teratas --}}
                                @include('kluster.partials._row', ['kluster' => $kluster, 'level' => 0])
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada kluster/menu yang ditambahkan.</td>
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

 <script>
        $(document).ready(function() {
            // Script untuk modal konfirmasi hapus
            // Script ini akan otomatis bekerja pada tombol apapun yang memiliki
            // atribut data-toggle="modal" dan data-target="#deleteModal"
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);
                modal.find('#deleteForm').attr('action', url);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Script untuk modal konfirmasi hapus
            // Script ini akan otomatis bekerja pada tombol apapun yang memiliki
            // atribut data-toggle="modal" dan data-target="#deleteModal"
            $('#deleteModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var url = button.data('url');
                var modal = $(this);
                modal.find('#deleteForm').attr('action', url);
            });
        });
    </script>

{{--
    REVISI PENTING #3: Penempatan & Perbaikan Script
    Menambahkan blok @section('scripts') terpisah untuk JavaScript.
    Ini memastikan jQuery (dari file JS utama) sudah dimuat sebelum script ini dijalankan.
--}}

</body>
</html>
