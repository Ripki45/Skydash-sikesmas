@extends('layouts.frontend')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-4">
            {{-- KOLOM KIRI (UTAMA): DAFTAR BERITA --}}
            <div class="col-lg-8">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-4">Pengumuman!</h1>
                    <p>Ikuti perkembangan dan informasi terbaru kami.</p>
                </div>
                <div class="row g-4">
                    @forelse ($pengumumans as $pengumuman)
                    <div class="col-md-6">
                        <div class="card pengumuman-item-card h-100">
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="badge bg-primary text-white">{{ $pengumuman->tipe }}</span>
                                </div>
                                {{-- Nanti kita buat link detailnya --}}
                                <a href="#" class="h5 d-block mb-3 card-title">{{ Str::limit($pengumuman->judul, 60) }}</a>
                                <p class="card-text text-muted">
                                    {!! Str::limit(strip_tags($pengumuman->isi), 100) !!}
                                </p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <small class="text-body"><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ $pengumuman->created_at->format('d M Y') }}</small>
                                    {{-- Nanti kita buat link detailnya --}}
                                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-secondary text-center">Belum ada pengumuman untuk ditampilkan.</div>
                    </div>
                    @endforelse

                    {{-- Link Pagination --}}
                    <div class="col-12 mt-4">
                        <div class="d-flex justify-content-center">
                            {{ $pengumumans->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <div class="col-lg-4">
                <div class="sidebar-widget-area">
                    {{-- Widget Search --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Cari</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Kata kunci...">
                            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                        </div>
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
                    {{-- Widget Layanan --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Layanan Kami</h5>
                        {{-- PASTIKAN CLASS-NYA INI --}}
                        <div class="layanan-carousel owl-carousel">
                            @forelse ($layanans as $layanan)
                                {{-- Setiap item sekarang menjadi slide di dalam carousel --}}
                                <div class="item">
                                    <a href="{{ $layanan->link }}" target="_blank" class="layanan-card-link">
                                        <div class="layanan-item text-center p-4">
                                            <div class="layanan-icon mb-3">
                                                <img src="{{ asset('storage/' . $layanan->gambar_icon) }}" alt="{{ $layanan->nama_layanan }}">
                                            </div>
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Styling untuk Kartu Berita */
    .berita-item-2 { box-shadow: 0 0 45px rgba(0, 0, 0, .07); transition: .5s; margin-bottom: 1.5rem; }
    .berita-item-2:hover { box-shadow: 0 0 45px rgba(0, 0, 0, .2); }
    .berita-img-2 { position: relative; height: 250px; }
    .berita-img-2 img { width: 100%; height: 100%; object-fit: cover; }
    .berita-content-2 a.badge { font-size: 0.8rem; }
    .pagination .page-link { color: var(--bs-primary); }
    .pagination .page-item.active .page-link { background-color: var(--bs-primary); border-color: var(--bs-primary); color: white; }

    /* Styling untuk Sidebar */
    .sidebar-widget-area .widget-item { background-color: #f8f9fa; padding: 20px; border-radius: 8px; }
    .layanan-sidebar-item { background: white; padding: 20px; border-radius: 8px; text-align: center; }
    .tag-cloud a { background-color: white; border: 1px solid #eee; }
</style>
@endsection

@push('custom-scripts')
<script>
    $(document).ready(function(){
        // "Mesin" untuk carousel di HALAMAN DEPAN (jika ada)
        $('.layanan-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            margin: 50,
            loop: true,
            center: true,
            dots: false,
            nav : true,
            navText : [
                '<i class="bi bi-arrow-left"></i>',
                '<i class="bi bi-arrow-right"></i>'
            ],
            responsive:{
                0:{ items:1 },
                768:{ items:2 },
                992:{ items:3 },
                1200:{ items:4 }
            }
        });

        // ======================================================
        // !! INILAH "MESIN" BARU KHUSUS UNTUK SIDEBAR !!
        // ======================================================
        $('.layanan-sidebar-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 800,
            // HANYA TAMPILKAN 1 ITEM KARENA DI SIDEBAR
            items: 2,
            dots: true,
            loop: true,
            nav : false // Tidak perlu tombol navigasi di sidebar
        });
    });
</script>
@endpush
