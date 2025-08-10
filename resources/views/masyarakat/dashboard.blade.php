@extends('layouts.app') {{-- Gunakan layout yang sama dengan admin atau buat layout khusus --}}

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <h3 class="font-weight-bold">Selamat Datang, {{ Auth::user()->name }}!</h3>
        <h6 class="font-weight-normal mb-0">Berikut adalah pengumuman terbaru dari puskesmas.</h6>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <h4><i class="ti-announcement"></i> Pengumuman Penting</h4>
        <hr>
        @forelse($pengumumans as $pengumuman)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">{{ $pengumuman->judul }}</h5>
                        <small class="text-muted">Dipublikasikan pada: {{ $pengumuman->created_at->format('d M Y') }}</small>
                    </div>
                    <p class="card-text">{!! $pengumuman->isi !!}</p>

                    @if($pengumuman->lampiran)
                        <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="btn btn-outline-info btn-sm">Lihat Lampiran</a>
                    @endif

                    {{-- INILAH BAGIAN INTERAKTIFNYA --}}
                    @if($pengumuman->konfirmasi_diperlukan)
                        <hr>
                        <div class="mt-2">
                            {{-- Cek apakah user sudah konfirmasi --}}
                            @if(in_array($pengumuman->id, $confirmedIds))
                                <button class="btn btn-success" disabled>
                                    <i class="ti-check"></i> Sudah Dikonfirmasi
                                </button>
                            @else
                                <form action="{{ route('admin.pengumuman.konfirmasi', $pengumuman->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti-thumb-up"></i> Konfirmasi Kehadiran
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Saat ini belum ada pengumuman baru.
            </div>
        @endforelse
    </div>
</div>
@endsection
