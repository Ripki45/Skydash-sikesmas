@extends('layouts.frontend')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <ol class="breadcrumb justify-content-start mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active text-dark">{{ $halaman->judul }}</li>
        </ol>

        <div class="row g-4">
            {{-- KOLOM KIRI: KONTEN UTAMA HALAMAN --}}
            <div class="col-lg-8">
                <div class="mb-4">
                    <h1 class="display-5">{{ $halaman->judul }}</h1>
                </div>

                @if($halaman->gambar_unggulan)
                <div class="position-relative rounded overflow-hidden mb-3">
                    <img src="{{ asset('storage/' . $halaman->gambar_unggulan) }}" class="img-fluid rounded w-100" alt="{{ $halaman->judul }}">
                </div>
                @endif

                <div class="d-flex justify-content-start text-muted small mb-4">
                    <span class="me-3"><i class="fa fa-calendar-alt"></i> Dipublikasikan pada: {{ $halaman->created_at->format('d M Y') }}</span>
                </div>

                <div class="isi-halaman">
                    {!! $halaman->konten !!}
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR BERITA TERBARU --}}
            <div class="col-lg-4">
                <div class="p-3 rounded border">
                     <h4 class="mb-4">Berita Terbaru</h4>
                     {{-- REVISI: Blok @php dihapus, foreach langsung menggunakan $beritaTerbaru dari controller --}}
                     @foreach($beritaTerbaru as $berita)
                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-4">
                                <div class="overflow-hidden rounded">
                                    <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="features-content d-flex flex-column">
                                    <a href="#" class="h6">{{ Str::limit($berita->judul, 35) }}</a>
                                    <small><i class="fas fa-calendar-alt me-1"></i> {{ $berita->published_at->isoFormat('dddd, D MMMM YYYY') }}</small>
                                </div>
                            </div>
                        </div>
                     @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
