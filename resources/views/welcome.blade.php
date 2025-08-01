@extends('layouts.frontend')

@section('content')
        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->

        <!-- Banner Start -->
        @if($banners->isNotEmpty())
            <div class="container-fluid-full mt-2">
                <div class="banner-carousel owl-carousel">
                    @foreach($banners as $banner)
                    <div class="item">
                        <img src="{{ asset('storage/' . $banner->gambar_banner) }}" alt="{{ $banner->judul_banner }}">
                    </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- Features End -->

        {{-- Layanan Start --}}
        <div class="container-fluid py-2">
            <div class="container py-4">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h3 class="display-6">Layanan Unggulan</h3>
                    <p>Geser untuk mendapatkan Informasi dan akses cepat ke berbagai layanan kesehatan kami.</p>
                </div>
                {{-- REVISI: Menggunakan div untuk Owl Carousel --}}
                <div class="layanan-carousel owl-carousel">
                    @forelse ($layanans as $layanan)
                        {{-- Setiap item sekarang menjadi slide di dalam carousel --}}
                        <div class="item">
                            <a href="{{ $layanan->link }}" target="_blank" class="layanan-card-link">
                                <div class="layanan-item text-center p-4">
                                    <div class="layanan-icon mb-3">
                                        <img src="{{ asset('storage/' . $layanan->gambar_icon) }}" alt="{{ $layanan->nama_layanan }}">
                                    </div>
                                    <h5 class="mb-0">{{ $layanan->nama_layanan }}</h5>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Data layanan belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        {{-- layanan End --}}

        {{-- pengumuman dan slider berita --}}
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row">
                    {{-- KOLOM KIRI: SLIDER BERITA --}}
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <h3 class="display-6">Berita Terkini</h3>
                        </div>
                        <div class="berita-carousel owl-carousel">
                            @forelse($beritas as $berita)
                            <div class="item">
                                <div class="berita-item">
                                    <div class="berita-img">
                                        <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-fluid w-100 rounded" alt="{{ $berita->judul }}">
                                    </div>
                                    <div class="berita-content bg-light p-4 rounded-bottom">
                                        <a href="#" class="badge badge-primary-soft mb-3">{{ $berita->kategori->nama_kategori }}</a>
                                        <a href="#" class="h4 d-block mb-3">{{ Str::limit($berita->judul, 60) }}</a>
                                        <div class="d-flex justify-content-between">
                                            <a href="#" class="small text-body link-hover">by {{ $berita->user->name }}</a>
                                            <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {{ $berita->published_at->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="item"><p>Belum ada berita untuk ditampilkan.</p></div>
                            @endforelse
                        </div>
                    </div>

                    {{-- KOLOM KANAN: DAFTAR PENGUMUMAN --}}
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <h3 class="display-6">Pengumuman</h3>
                        </div>
                        <div class="pengumuman-list">
                            @forelse($pengumumans as $item)
                            <div class="pengumuman-item">
                                <div class="pengumuman-content">
                                    <a href="#" class="h6">{{ $item->judul }}</a>
                                    <small class="text-muted d-block"><i class="fas fa-calendar-alt me-1"></i> Berlaku s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</small>
                                </div>
                            </div>
                            @empty
                            <p>Tidak ada pengumuman.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Main Post Section Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-lg-7 col-xl-8 mt-0">
                        <div class="position-relative overflow-hidden rounded">
                            <img src="{{ asset('frontend/img/news-1.jpg') }}" class="img-fluid rounded img-zoomin w-100" alt="">
                            <div class="d-flex justify-content-center px-4 position-absolute flex-wrap" style="bottom: 10px; left: 0;">
                                <a href="#" class="text-white me-3 link-hover"><i class="fa fa-clock"></i> 06 minute read</a>
                                <a href="#" class="text-white me-3 link-hover"><i class="fa fa-eye"></i> 3.5k Views</a>
                                <a href="#" class="text-white me-3 link-hover"><i class="fa fa-comment-dots"></i> 05 Comment</a>
                                <a href="#" class="text-white link-hover"><i class="fa fa-arrow-up"></i> 1.5k Share</a>
                            </div>
                        </div>
                        <div class="border-bottom py-3">
                            <a href="#" class="display-4 text-dark mb-0 link-hover">Lorem Ipsum is simply dummy text of the printing</a>
                        </div>
                        <p class="mt-3 mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley standard dummy text ever since the 1500s, when an unknown printer took a galley...
                        </p>
                        <div class="bg-light p-4 rounded">
                            <div class="news-2">
                                <h3 class="mb-4">Top Story</h3>
                            </div>
                            <div class="row g-4 align-items-center">
                                <div class="col-md-6">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/news-2.jpg') }}" class="img-fluid rounded img-zoomin w-100" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="h3">Stoneman Clandestine Ukrainian claims successes against Russian.</a>
                                        <p class="mb-0 fs-5"><i class="fa fa-clock"> 06 minute read</i> </p>
                                        <p class="mb-0 fs-5"><i class="fa fa-eye"> 3.5k Views</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                       <div class="bg-light rounded p-4 pt-0">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('frontend/img/news-3') }}img/news-3.jpg" class="img-fluid rounded img-zoomin w-100" alt="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="h4 mb-2">Get the best speak market, news.</a>
                                        <p class="fs-5 mb-0"><i class="fa fa-clock"> 06 minute read</i> </p>
                                        <p class="fs-5 mb-0"><i class="fa fa-eye"> 3.5k Views</i></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-5">
                                            <div class="overflow-hidden rounded">
                                                <img src="{{ asset('frontend/img/news-3.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="features-content d-flex flex-column">
                                                <a href="#" class="h6">Get the best speak market, news.</a>
                                                <small><i class="fa fa-clock"> 06 minute read</i> </small>
                                                <small><i class="fa fa-eye"> 3.5k Views</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-5">
                                            <div class="overflow-hidden rounded">
                                                <img src="{{ asset('frontend/img/news-4.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="features-content d-flex flex-column">
                                                <a href="#" class="h6">Get the best speak market, news.</a>
                                                <small><i class="fa fa-clock"> 06 minute read</i> </small>
                                                <small><i class="fa fa-eye"> 3.5k Views</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-5">
                                            <div class="overflow-hidden rounded">
                                                <img src="{{ asset('frontend/img/news-5.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="features-content d-flex flex-column">
                                                <a href="#" class="h6">Get the best speak market, news.</a>
                                                <small><i class="fa fa-clock"> 06 minute read</i> </small>
                                                <small><i class="fa fa-eye"> 3.5k Views</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-5">
                                            <div class="overflow-hidden rounded">
                                                <img src="{{ asset('frontend/img/news-6.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="features-content d-flex flex-column">
                                                <a href="#" class="h6">Get the best speak market, news.</a>
                                                <small><i class="fa fa-clock"> 06 minute read</i> </small>
                                                <small><i class="fa fa-eye"> 3.5k Views</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-5">
                                            <div class="overflow-hidden rounded">
                                                <img src="{{ asset('frontend/img/news-7.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="features-content d-flex flex-column">
                                                <a href="#" class="h6">Get the best speak market, news.</a>
                                                <small><i class="fa fa-clock"> 06 minute read</i> </small>
                                                <small><i class="fa fa-eye"> 3.5k Views</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-4 align-items-center">
                                        <div class="col-5">
                                            <div class="overflow-hidden rounded">
                                                <img src="{{ asset('frontend/img/news-7.jpg') }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="features-content d-flex flex-column">
                                                <a href="#" class="h6">Get the best speak market, news.</a>
                                                <small><i class="fa fa-clock"> 06 minute read</i> </small>
                                                <small><i class="fa fa-eye"> 3.5k Views</i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Post Section End -->
@endsection

@push('custom-scripts')
    <script>
        // Inisialisasi Banner Carousel
        $('.banner-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            center: true,
            dots: true,
            loop: true,
            margin: 0,
            nav : false,
            responsiveClass: true,
            responsive: {
                0:{
                    items:1
                },
                0:{
                    items:1
                },
                0:{
                    items:1
                },
                0:{
                    items:1
                }
            }
        });
    </script>
@endpush

@push('custom-scripts')
<script>
    // Inisialisasi Banner Carousel (yang sudah ada)
    $('.banner-carousel').owlCarousel({
        // ... opsi untuk banner ...
    });

    // =======================================================
    // TAMBAHKAN KODE BARU INI UNTUK SLIDER LAYANAN
    // =======================================================
    $('.layanan-carousel').owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        loop: true,
        center: false,
        dots: false,
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:2
            },
            768:{
                items:3
            },
            992:{
                items:4
            }
        }
    });
</script>
@endpush

@push('costum-script')
    $('.berita-carousel').owlCarousel({
    autoplay: true,
    smartSpeed: 1000,
    margin: 25,
    loop: true,
    center: false,
    dots: false,
    nav: true,
    navText : [
        '<i class="bi bi-chevron-left"></i>',
        '<i class="bi bi-chevron-right"></i>'
    ],
    responsive: {
        0:{ items:1 },
        768:{ items:2 },
        992:{ items:2 }
    }
});
@endpush

