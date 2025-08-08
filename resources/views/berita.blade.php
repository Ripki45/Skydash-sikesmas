@extends('layouts.frontend')

@section('content')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="row g-4">
            {{-- KOLOM KIRI (UTAMA): DAFTAR BERITA --}}
            <div class="col-lg-8">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-4">Semua Berita</h1>
                    <p>Ikuti perkembangan dan informasi terbaru dari kegiatan kami.</p>
                </div>
                <div class="row g-4">
                    @forelse($beritas as $berita)
                    <div class="col-md-6">
                        <div class="berita-item-2 rounded">
                            <div class="berita-img-2 rounded-top overflow-hidden">
                                <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-fluid w-100" alt="{{ $berita->judul }}">
                            </div>
                            <div class="berita-content-2 p-4">
                                <a href="#" class="badge badge-primary-soft mb-3">{{ $berita->kategori->nama_kategori }}</a>
                                <a href="#" class="h5 d-block mb-3">{{ Str::limit($berita->judul, 50) }}</a>
                                <div class="d-flex justify-content-between">
                                    <small class="text-body"><i class="fa fa-user me-2 text-primary"></i>{{ $berita->user->name }}</small>
                                    <small class="text-body d-block"><i class="fas fa-calendar-alt me-2 text-primary"></i>{{ $berita->published_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-secondary text-center">Belum ada berita untuk ditampilkan.</div>
                    </div>
                    @endforelse

                    {{-- Link Pagination --}}
                    <div class="col-12 mt-5">
                        <div class="d-flex justify-content-center">
                            {{ $beritas->links() }}
                        </div>
                    </div>
                </div>
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

                    {{-- Widget Layanan Carousel --}}
                    <div class="widget-item mb-4">
                        <h5 class="mb-3">Layanan Kami</h5>
                        <div class="layanan-sidebar-carousel owl-carousel">
                            @foreach($layanans as $layanan)
                            <div class="item">
                                <div class="layanan-sidebar-item">
                                    <i class="{{ $layanan->icon_layanan }} fa-3x text-primary mb-3"></i>
                                    <h6>{{ $layanan->nama_layanan }}</h6>
                                </div>
                            </div>
                            @endforeach
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
        // Inisialisasi Carousel untuk Layanan di Sidebar
        $('.layanan-sidebar-carousel').owlCarousel({
            autoplay: true,
            smartSpeed: 1000,
            items: 1,
            dots: true,
            loop: true,
            nav : false
        });
    });
</script>
@endpush
