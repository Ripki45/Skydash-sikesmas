@extends('layouts.frontend')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        {{-- Breadcrumb Dinamis --}}
        <ol class="breadcrumb justify-content-start mb-4">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('berita.semua') }}">Artikel</a></li>
            <li class="breadcrumb-item active text-dark">{{ Str::limit($berita->judul, 50) }}</li>
        </ol>
        <div class="row g-4">
            {{-- KOLOM KIRI: KONTEN UTAMA BERITA --}}
            <div class="col-lg-8">
                <div class="mb-4">
                    <h1 class="display-5">{{ $berita->judul }}</h1>
                </div>
                <div class="position-relative rounded overflow-hidden mb-3">
                    <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-zoomin img-fluid rounded w-100" alt="{{ $berita->judul }}">
                    <div class="position-absolute text-white px-4 py-2 bg-primary rounded" style="top: 20px; right: 20px;">
                        {{ $berita->kategori->nama_kategori }}
                    </div>
                </div>
                <div class="d-flex justify-content-between text-muted small">
                    <span><i class="fa fa-user"></i> Oleh: {{ $berita->user->name }}</span>
                    <span><i class="fa fa-calendar-alt"></i> {{ $berita->published_at->format('d M Y') }}</span>
                    <span><i class="fa fa-eye"></i> 3.5k Views</span>
                </div>
                <div class="isi-berita my-4">
                    {!! $berita->isi_berita !!}
                </div>

                {{-- Bagian Tags & Share --}}
                <div class="d-flex justify-content-between border-top border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">Tags:</h5>
                        @foreach($berita->tags as $tag)
                            <a href="#" class="btn btn-light btn-sm rounded-pill me-2">{{ $tag->nama_tag }}</a>
                        @endforeach
                    </div>
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">Share:</h5>
                        <a href="#" class="btn btn-square rounded-circle border-primary text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-square rounded-circle border-primary text-dark me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-square rounded-circle border-primary text-dark"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                {{-- Berita Terkait --}}
                @if($beritaTerkait->isNotEmpty())
                <div class="bg-light rounded my-4 p-4">
                    <h4 class="mb-4">Berita Terkait</h4>
                    <div class="row g-4">
                        @foreach($beritaTerkait as $terkait)
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center p-3 bg-white rounded">
                                <img src="{{ asset('storage/' . $terkait->gambar_unggulan) }}" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="">
                                <div class="ms-3">
                                    <a href="{{ route('artikel.show', $terkait->slug) }}" class="h5 mb-2">{{ Str::limit($terkait->judul, 30) }}</a>
                                    <p class="text-dark mt-2 mb-0 me-3 small"><i class="fa fa-clock"></i> {{ $terkait->published_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <div class="col-lg-4">
                <div class="sidebar-widget-area">
                    {{-- Widget Search --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Cari Berita</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Kata kunci...">
                            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                    {{-- Widget Kategori --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Kategori</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($kategoris as $kategori)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="#">{{ $kategori->nama_kategori }}</a>
                                <span class="badge bg-primary rounded-pill">{{ $kategori->beritas_count }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Widget Trending Tags --}}
                    <div class="widget-item">
                        <h5 class="mb-3">Trending Tags</h5>
                        <div class="tag-cloud">
                            @foreach($trendingTags as $tag)
                                <a href="#" class="btn btn-light btn-sm rounded-pill mb-2">{{ $tag->nama_tag }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
