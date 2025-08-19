
@extends('layouts.frontend')

@section('title', $pengumuman->judul)

@section('content')

<!-- Header Halaman -->
<div class="container-fluid page-header py-5">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white mb-4 animated slideInDown">{{ Str::limit($pengumuman->judul, 40) }}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pengumuman.semua') }}">Pengumuman</a></li>
                <li class="breadcrumb-item text-white" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Header Halaman End -->

<!-- Detail Pengumuman Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-5">
            {{-- KOLOM KIRI (UTAMA): ISI PENGUMUMAN --}}
            <div class="col-lg-8">
                <div class="mb-4">
                    <h1 class="display-6">{{ $pengumuman->judul }}</h1>
                    <p class="text-muted">
                        <small>
                            <i class="fa fa-calendar-alt me-1"></i> Dipublikasikan pada {{ $pengumuman->created_at->isoFormat('D MMMM Y') }}
                            <span class="mx-2">|</span>
                            <i class="fa fa-tag me-1"></i> Tipe: {{ $pengumuman->tipe }}
                        </small>
                    </p>
                </div>
                <hr>
                <div class="content-detail">
                    {!! $pengumuman->isi !!}
                </div>

                @if($pengumuman->lampiran)
                <div class="mt-4">
                    <a href="{{ asset('storage/' . $pengumuman->lampiran) }}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-download me-2"></i> Unduh Lampiran
                    </a>
                </div>
                @endif
            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 120px;">
                    {{-- Widget Pengumuman Lainnya --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Pengumuman Lainnya</h5>
                        @forelse($pengumumanLainnya as $item)
                        <div class="d-flex mb-3">
                            <div class="ms-3">
                                <a href="{{ route('pengumuman.show', $item->slug) }}" class="h6">{{ Str::limit($item->judul, 50) }}</a>
                                <small class="d-block text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ $item->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="small text-muted">Tidak ada pengumuman lainnya.</p>
                        @endforelse
                    </div>

                    {{-- Widget Berita Terbaru --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Berita Terbaru</h5>
                        @forelse($beritaTerbaru as $berita)
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="">
                            <div class="ms-3">
                                <a href="{{ route('artikel.show', $berita->slug) }}" class="h6">{{ Str::limit($berita->judul, 45) }}</a>
                                <small class="d-block text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ $berita->published_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="small text-muted">Belum ada berita terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Detail Pengumuman End -->

@endsection
