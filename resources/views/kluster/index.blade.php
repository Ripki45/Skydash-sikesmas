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
                                <th>No.</th>
                                <th>Kluster</th>
                                <th>Halaman Terhubung</th>
                                <th>Link Manual</th>
                                <th>Urutan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Kita gunakan variabel counter manual karena $loop->iteration akan reset di loop dalam --}}
                            @php $no = 1; @endphp

                            @forelse ($klusters as $kluster)
                                {{-- Tampilkan Menu Induk --}}
                                <tr style="background-color: #f3f3f3;">
                                    <td>{{ $no++ }}</td>
                                    <td><strong>{{ $kluster->title }}</strong></td>
                                    <td>
                                        @if($kluster->halaman_id)
                                            <span class="badge badge-info">Terhubung ke Halaman</span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $kluster->url ?? '-' }}</td>
                                    <td>{{ $kluster->order }}</td>
                                    <td>
                                        <a href="{{ route('kluster.edit', $kluster->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm"
                                                data-toggle="modal" data-target="#deleteModal"
                                                data-url="{{ route('kluster.destroy', $kluster->id) }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>

                                {{-- Tampilkan semua Sub-Menu (Anak) dari menu induk ini --}}
                                @if($kluster->children->isNotEmpty())
                                    @foreach($kluster->children as $child)
                                    <tr>
                                        <td></td>
                                        {{-- Kita beri sedikit indentasi agar terlihat seperti sub-menu --}}
                                        <td style="padding-left: 2rem;">
                                            <i class="mdi mdi-arrow-right-bold-circle-outline"></i> {{ $child->title }}
                                        </td>
                                        <td>
                                            @if($child->halaman_id)
                                                <span class="badge badge-info">Terhubung ke Halaman</span>
                                            @else
                                                <span class="badge badge-secondary">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $child->url ?? '-' }}</td>
                                        <td>{{ $child->order }}</td>
                                        <td>
                                            <a href="{{ route('kluster.edit', $child->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <button type-="button" class="btn btn-danger btn-sm"
                                                    data-toggle="modal" data-target="#deleteModal"
                                                    data-url="{{ route('kluster.destroy', $child->id) }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data Kluster masih kosong.</td>
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

{{--
    REVISI PENTING #3: Penempatan & Perbaikan Script
    Menambahkan blok @section('scripts') terpisah untuk JavaScript.
    Ini memastikan jQuery (dari file JS utama) sudah dimuat sebelum script ini dijalankan.
--}}
@section('scripts')
<script>
    $(document).ready(function() {
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', url);
        });
    });
</script>
@endsection

</body>
</html>
