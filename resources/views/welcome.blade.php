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
            <div class="container-fluid-full">
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
        <div class="container-fluid py-2" style="background-color: #f8f9fa;">
            <div class="container py-1">
                <div class="sinergi-carousel owl-carousel">
                    @forelse ($sinergiPrograms as $program)
                        <div class="item">
                            <a href="{{ $program->link }}" target="_blank" class="sinergi-card-link">
                                {{-- REVISI: Ubah class agar tidak sama dengan layanan --}}
                                <div class="sinergi-item text-center p-2">
                                    <div class="sinergi-icon mb-2">
                                        <img src="{{ asset('storage/' . $program->gambar_icon) }}" alt="{{ $program->nama_program }}">
                                    </div>
                                    <h6 class="mb-0">{{ $program->nama_program }}</h6>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="item text-center">
                            <p>Data Sinergi Program belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Layanan Start --}}
        <div class="container-fluid py-4">
            <div class="container py-2">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h3 class="display-7">Layanan Unggulan</h3>
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

        <section class="bg-light py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h3 class="display-7 fw-bold">Tentang Kami</h3>
                </div>

                <div class="row align-items-center g-5">
                    {{-- KOLOM KIRI: FOTO PUSKESMAS --}}
                    <div class="col-lg-6">
                        @if(!empty($settings['foto_puskesmas']))
                            <img src="{{ asset('storage/' . $settings['foto_puskesmas']) }}" alt="Gedung Puskesmas" class="img-fluid rounded shadow-sm w-100">
                        @else
                            <img src="https://placehold.co/600x400/e9ecef/343a40?text=Foto+Puskesmas" alt="Gedung Puskesmas" class="img-fluid rounded shadow-sm w-100">
                        @endif
                    </div>

                    {{-- KOLOM KANAN: DESKRIPSI, VISI, & MISI --}}
                    <div class="col-lg-6">
                        {{-- PERBAIKAN #1: Menggunakan {!! !!} untuk merender HTML dari deskripsi --}}
                        {{-- PERBAIKAN #2: Menghapus class text-center dan menggunakan text-start (rata kiri) --}}
                        <div class="text-start mb-4">
                            {!! $settings['deskripsi'] ?? '<p>Deskripsi tentang Puskesmas belum diisi.</p>' !!}
                        </div>

                        <h4 class="fw-bold">Visi</h4>
                        {{-- PERBAIKAN #3: Menggunakan {!! !!} untuk Visi --}}
                        <div class="fst-italic text-primary mb-3">
                            {!! $settings['visi'] ?? '<p>"Visi belum diisi."</p>' !!}
                        </div>

                        <h4 class="fw-bold">Misi</h4>
                        {{-- PERBAIKAN #4: Menggunakan {!! !!} untuk Misi --}}
                        <div class="text-start">
                            {!! $settings['misi'] ?? '<ul><li>Misi belum diisi.</li></ul>' !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- pengumuman dan slider berita --}}
        <div class="container-fluid py-5">
            <div class="container py-3">
                <div class="row">
                    {{-- KOLOM KIRI: SLIDER BERITA --}}
                    <div class="col-lg-7">
                        <div class="mb-4">
                            <h3 class="display-7">Berita Terkini</h3>
                        </div>

                        {{-- REVISI: Tambahkan kondisi jika berita tidak kosong --}}
                        @if($beritas->isNotEmpty())
                            <div class="berita-carousel owl-carousel">
                                @foreach($beritas as $berita)
                                <div class="item">
                                    <div class="berita-item">
                                        <div class="berita-img">

                                            <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-fluid w-100 rounded" alt="{{ $berita->judul }}">
                                        </div>
                                        <div class="berita-content bg-light p-5 rounded-bottom">
                                            <a href="#" class="badge badge-primary-soft mb-3">{{ $berita->kategori->nama_kategori }}</a>
                                            <a href="{{ route('artikel.show', $berita->slug) }}"class="h4 d-block mb-3">{{ Str::limit($berita->judul, 60) }}</a>
                                            <div class="d-flex justify-content-between">
                                                <a href="#" class="small text-body link-hover">by {{ $berita->user->name }}</a>
                                                <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {{ $berita->published_at->isoFormat('dddd, D MMMM YYYY') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            {{-- REVISI: Tampilkan pesan ini jika berita kosong --}}
                            <div class="alert alert-secondary text-center">
                                Belum ada berita untuk ditampilkan.
                            </div>
                        @endif
                    </div>

                    {{-- KOLOM KANAN: DAFTAR PENGUMUMAN --}}
                    <div class="col-lg-5">
                        <div class="mb-4">
                            <h3 class="display-7">Pengumuman</h3>
                        </div>
                        <div class="pengumuman-list">
                            @forelse($pengumumans as $item)
                            <div class="pengumuman-item mb-3 pb-3 border-bottom">
                                <div class="pengumuman-content">
                                    {{-- Arahkan link ini ke halaman detail jika ada, atau biarkan # --}}
                                    <a href="{{ route('pengumuman.show', $item->id) }}" class="h6">{{ $item->judul }}</a>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Berlaku s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            @empty
                            <p>Tidak ada pengumuman.</p>
                            @endforelse

                            {{-- INILAH PENAMBAHANNYA --}}
                            @if($pengumumans->isNotEmpty())
                            <div class="mt-2 text-end">
                                <a href="{{ route('pengumuman.semua') }}" class="text-primary link-hover">
                                    Lihat Selengkapnya... <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container py-2">
            <div class="container py-1">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-7">Tenaga Kesehatan Kami</h1>
                    <p>Tim profesional yang berdedikasi untuk melayani Anda.</p>
                </div>

                <div class="tenaga-kesehatan-carousel owl-carousel">
                    @forelse ($tenagaKesehatans as $nakes)
                        <div class="item">
                            <div class="nakes-item text-center">
                                <div class="nakes-img">
                                    <img src="{{ $nakes->foto ? asset('storage/' . $nakes->foto) : 'https://via.placeholder.com/200x200.png?text=Foto' }}" alt="{{ $nakes->nama_lengkap }}">
                                </div>
                                <div class="nakes-content">
                                    <h5 class="mb-1">{{ $nakes->nama_lengkap }}</h5>
                                    <p class="mb-0 text-muted">{{ $nakes->jabatan }}</p>
                                    @if($nakes->nip_nik)
                                        <small class="text-muted">NIP/NIK: {{ $nakes->nip_nik }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="item text-center">
                            <p>Data tenaga kesehatan belum tersedia.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="container-fluid py-5" style="background-color: #f8f9fa;">
            <div class="container py-2">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-7">Jadwal Kegiatan</h1>
                    <p>Temukan jadwal kegiatan Posyandu Balita, Lansia, Remaja, dan Posbindu di wilayah Anda.</p>
                </div>
                <div class="row g-4">
                    {{-- KOLOM KIRI: FILTER --}}
                    <div class="col-lg-3">
                        <div class="jadwal-filter p-4 rounded bg-white shadow-sm mb-4">
                            <h5 class="mb-3">Cari Jadwal</h5>
                            <div class="form-group mb-3">
                                <label for="desa_filter" class="form-label">Desa</label>
                                <select id="desa_filter" class="form-select">
                                    <option value="">Semua Desa</option>
                                    @foreach($desas as $desa)
                                        <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="dusun_filter" class="form-label">Dusun</label>
                                <select id="dusun_filter" class="form-select" disabled>
                                    <option value="">Semua Dusun</option>
                                </select>
                            </div>
                            {{-- REVISI: Tambahkan dropdown Posyandu --}}
                            <div class="form-group mb-3">
                                <label for="posyandu_filter" class="form-label">Posyandu</label>
                                <select id="posyandu_filter" class="form-select" disabled>
                                    <option value="">Semua Posyandu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM TENGAH: JADWAL TERDEKAT --}}
                    <div class="col-lg-4">
                        <h5 class="mb-3">Jadwal Terdekat</h5>
                        <div id="jadwal-list" class="upcoming-events">
                            {{-- Daftar jadwal akan dimuat di sini oleh JavaScript --}}
                        </div>
                    </div>

                    {{-- KOLOM KANAN: KALENDER --}}
                    <div class="col-lg-5">
                        <h5 class="mb-3">Kalender</h5>
                        <div class="calendar-widget p-3 rounded bg-white shadow-sm">
                            {{-- Kalender akan dimuat di sini oleh JavaScript --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-5 my-2" style=" background: linear-gradient(rgba(202, 203, 185, 1),rgba(202, 203, 185, 1));">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7">
                        <h1 class="mb-4 text-primary">Artikel </h1>
                        <h1 class="mb-4">Ikuti Kegiatan Kami</h1>
                        <p class="text-dark mb-4 pb-2">
                            Sekarang informasi terkait posyandu, pengumuman dan semua ada dalam website ini
                            ayo ikuti perkembangan kami
                        </p>
                        <div class="position-relative mx-auto">
                            <input
                                class="form-control w-100 py-3 rounded-pill"
                                type="email"
                                placeholder="Your Busines Email"/>
                            <button
                                type="submit"
                                class="btn btn-primary py-3 px-5 position-absolute rounded-pill text-white h-100"
                                style="top: 0; right: 0">
                                Subscribe Now
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="rounded">
                        <img
                            src="{{ asset('frontend/img/banner-img.jpg') }}"
                            class="img-fluid rounded w-100 rounded"
                            alt=""
                        />
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Main Post Section Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="row g-4">
                    {{-- KOLOM KIRI (70%) --}}
                    <div class="col-lg-7 col-xl-8 mt-0">
                        @if($beritas->isNotEmpty())
                            @php
                                $beritaUtama = $beritas->first();
                                $beritaKedua = $beritas->slice(1, 1)->first();
                            @endphp

                            {{-- Berita Utama --}}
                            <div class="position-relative overflow-hidden rounded">
                                <img src="{{ asset('storage/' . $beritaUtama->gambar_unggulan) }}" class="img-fluid rounded img-zoomin w-100" alt="{{ $beritaUtama->judul }}">
                                <div class="d-flex justify-content-center px-4 position-absolute flex-wrap" style="bottom: 10px; left: 0;">
                                    <a href="#" class="text-white me-3 link-hover"><i class="fa fa-user"></i> {{ $beritaUtama->user->name }}</a>
                                    <a href="#" class="text-white me-3 link-hover"><i class="fa fa-folder"></i> {{ $beritaUtama->kategori->nama_kategori }}</a>
                                </div>
                            </div>
                            <div class="border-bottom py-3">
                                {{-- PERBAIKAN #1: Gunakan slug dari $beritaUtama --}}
                                <a href="{{ route('artikel.show', $beritaUtama->slug) }}" class="display-4 text-dark mb-0 link-hover">{{ $beritaUtama->judul }}</a>
                            </div>
                            <p class="mt-3 mb-4">{{ Str::limit(strip_tags($beritaUtama->isi_berita), 700) }}</p>

                            {{-- Berita Kedua ("Top Story") --}}
                            @if($beritaKedua)
                            <div class="bg-light p-4 rounded">
                                <div class="news-2"><h3 class="mb-4">Artikel Populer</h3></div>
                                <div class="row g-4 align-items-center">
                                    <div class="col-md-6">
                                        <div class="rounded overflow-hidden">
                                            <img src="{{ asset('storage/' . $beritaKedua->gambar_unggulan) }}" class="img-fluid rounded img-zoomin w-100" alt="{{ $beritaKedua->judul }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex flex-column">
                                            {{-- PERBAIKAN #2: Gunakan slug dari $beritaKedua --}}
                                            <a href="{{ route('artikel.show', $beritaKedua->slug) }}" class="h3">{{ $beritaKedua->judul }}</a>
                                            <p class="mb-0 fs-5"><i class="fa fa-clock"></i> {{ $beritaKedua->published_at->isoFormat('dddd, D MMMM YYYY') }}</p>
                                            <p class="mb-0 fs-5"><i class="fa fa-user"></i> {{ $beritaKedua->user->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>

                    {{-- KOLOM KANAN (30%) - Sidebar Berita Lainnya --}}
                    <div class="col-lg-5 col-xl-4">
                        <h4 class="my-5">Berita Lainnya</h4>
                        <div class="bg-light rounded p-4 pt-0">
                            @php
                                $sisaBerita = $beritas->slice(2);
                            @endphp
                            {{-- PERBAIKAN #3: Loop ini sudah benar, tidak perlu diubah --}}
                            @foreach($sisaBerita as $berita)
                                <div class="row g-4 align-items-center mb-3 pb-3 border-bottom">
                                    <div class="col-5">
                                        <div class="overflow-hidden rounded">
                                            <img src="{{ asset('storage/' . $berita->gambar_unggulan) }}" class="img-zoomin img-fluid rounded w-100" alt="">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="features-content d-flex flex-column">
                                            <a href="{{ route('artikel.show', $berita->slug) }}" class="h6">{{ $berita->judul }}</a>
                                            <small><i class="fa fa-clock"></i> {{ $berita->published_at->isoFormat('dddd, D MMMM YYYY') }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Post Section End -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-7">Galeri Kegiatan</h1>
                    <p>Dokumentasi berbagai kegiatan dan pelayanan di Puskesmas kami.</p>
                </div>

                <ul class="nav nav-pills justify-content-center mb-5">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="pill" href="#galeri-semua">Semua Kegiatan</a>
                    </li>
                    @foreach($galeriKategoris as $kategori)
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="pill" href="#galeri-kategori-{{ $kategori->id }}">{{ $kategori->nama_kategori }}</a>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content">
                    {{-- Tab untuk "Semua Kegiatan" --}}
                    <div id="galeri-semua" class="tab-pane fade show active">
                        @include('partials._galeri-layout', ['items' => $galeris, 'id' => 'semua'])
                    </div>

                    {{-- Tab untuk setiap kategori --}}
                    @foreach($galeriKategoris as $kategori)
                        <div id="galeri-kategori-{{ $kategori->id }}" class="tab-pane fade">
                            @include('partials._galeri-layout', ['items' => $kategori->galeris, 'id' => $kategori->id])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if(isset($popupPengumuman))
            <div class="modal fade" id="popupPengumumanModal" tabindex="-1" aria-labelledby="popupPengumumanLabel" aria-hidden="true">
                {{-- Sesuaikan ukuran modal agar lebih pas untuk gambar --}}
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content" style="background: transparent; border: none;">
                        <div class="modal-body p-0">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px; z-index: 10;"></button>

                            {{-- PERBAIKAN UTAMA: Tampilkan gambar dari kolom 'lampiran' --}}
                            @if($popupPengumuman->lampiran)
                                <img src="{{ asset('storage/' . $popupPengumuman->lampiran) }}" class="img-fluid rounded" alt="{{ $popupPengumuman->judul }}">
                            @else
                                {{-- Fallback jika gambar tidak ada --}}
                                <div class="bg-light p-5 rounded text-center">
                                    <h4>{{ $popupPengumuman->judul }}</h4>
                                    <p>Gambar tidak tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
@endsection

@push('custom-scripts')
<script>
$(document).ready(function () {
    var calendarEl = document.querySelector('.calendar-widget'); // Pastikan class ini ada di HTML-mu

    // Inisialisasi Kalender
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'id',
        initialView: 'dayGridMonth',
        height: 'auto',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        events: function (fetchInfo, successCallback, failureCallback) {
            fetchAndRenderJadwal(fetchInfo.startStr, fetchInfo.endStr, successCallback, failureCallback);
        },
        eventDidMount: function(info) {
            // Tooltip untuk event di kalender
            new bootstrap.Tooltip(info.el, {
                title: info.event.extendedProps.posyandu + ' (' + info.event.extendedProps.dusun + '): ' + info.event.title,
                placement: 'top',
                trigger: 'hover',
                container: 'body'
            });
        }
    });

    calendar.render();

    function fetchAndRenderJadwal(start = null, end = null, calendarCallback = null, failureCallback = null) {
        var desaId = $('#desa_filter').val();
        var dusunId = $('#dusun_filter').val();
        var posyanduId = $('#posyandu_filter').val();

        var url = new URL('{{ route("api.jadwal.filter") }}');
        if (start) url.searchParams.append('start', start);
        if (end) url.searchParams.append('end', end);
        if (desaId) url.searchParams.append('desa_id', desaId);
        if (dusunId) url.searchParams.append('dusun_id', dusunId);
        if (posyanduId) url.searchParams.append('posyandu_id', posyanduId);

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#jadwal-list').html(response.list_html);
                if (calendarCallback) {
                    calendarCallback(response.events);
                }
            },
            error: function() {
                if (failureCallback) failureCallback();
            }
        });
    }

    // Trigger reload saat filter berubah
    $('#desa_filter, #dusun_filter, #posyandu_filter').on('change', function () {
        calendar.refetchEvents();
    });

    // ======================================================
    // !! PERBAIKAN UTAMA ADA DI SINI !!
    // ======================================================

    // Desa -> Dusun
    $('#desa_filter').on('change', function () {
        var desaId = $(this).val();
        var dusunSelect = $('#dusun_filter');
        var posyanduSelect = $('#posyandu_filter');

        dusunSelect.prop('disabled', true).empty().append('<option value="">Semua Dusun</option>');
        posyanduSelect.prop('disabled', true).empty().append('<option value="">Semua Posyandu</option>');

        if (desaId) {
            $.ajax({
                // PERBAIKAN #1: Gunakan rute API publik yang benar
                url: '{{ route("api.getDusuns") }}',
                // PERBAIKAN #2: Gunakan metode POST
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    desa_id: desaId
                },
                success: function(data) {
                    dusunSelect.prop('disabled', false);
                    $.each(data, function(key, value) {
                        dusunSelect.append('<option value="' + value.id + '">' + value.nama_dusun + '</option>');
                    });
                }
            });
        }
    });

    // Dusun -> Posyandu
    $('#dusun_filter').on('change', function () {
        var dusunId = $(this).val();
        var posyanduSelect = $('#posyandu_filter');

        posyanduSelect.prop('disabled', true).empty().append('<option value="">Semua Posyandu</option>');

        if (dusunId) {
            $.ajax({
                // PERBAIKAN #3: Gunakan rute API publik yang benar
                url: '{{ route("api.getPosyandus") }}',
                // PERBAIKAN #4: Gunakan metode POST
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    dusun_id: dusunId
                },
                success: function(data) {
                    posyanduSelect.prop('disabled', false);
                    $.each(data, function(key, value) {
                        posyanduSelect.append('<option value="' + value.id + '">' + value.nama_posyandu + '</option>');
                    });
                }
            });
        }
    });

    // Pertama kali load list juga
    fetchAndRenderJadwal();
});
</script>
<script>
    function changeMainImage(id, newImageSrc, newCaption, newLightboxUrl) {
        document.getElementById('mainImage-' + id).src = newImageSrc;
        document.getElementById('caption-' + id).innerText = newCaption;
        // Update link lightbox juga
        document.getElementById('mainImage-' + id).parentElement.href = newLightboxUrl;
    }
</script>
<script>
    $(document).ready(function(){
        // ... (script carousel yang sudah ada)

        // ======================================================
        // !! SCRIPT BARU UNTUK MEMUNCULKAN POP-UP (VERSI LEBIH TANGGUH) !!
        // ======================================================

        // 1. Cari elemen modal menggunakan JavaScript biasa
        var popupModalElement = document.getElementById('popupPengumumanModal');

        // 2. Cek apakah elemen modal benar-benar ada di halaman
        if (popupModalElement) {
            // 3. Buat instance modal Bootstrap 5 secara resmi.
            // Ini adalah cara yang paling direkomendasikan.
            var popupModal = new bootstrap.Modal(popupModalElement);

            // 4. Tampilkan modalnya
            popupModal.show();
        }
    });
</script>
@endpush



