<!-- Topbar Start -->
<div class="container-fluid topbar bg-dark d-none d-lg-block">
    <div class="container px-0">
        <div class="d-flex justify-content-between align-items-center">

            {{-- Kolom Kiri: Running Text --}}
            <div class="top-info d-flex align-items-center">
                @if(isset($runningText) && $runningText->is_active)
                <span class="rounded-circle btn-sm-square bg-primary me-2">
                    <i class="fas fa-bolt text-white"></i>
                </span>
                <div class="pe-2 me-3 border-end border-white d-flex align-items-center">
                    <p class="mb-0 text-white fs-6 fw-normal">Info Terkini</p>
                </div>
                <div class="overflow-hidden" style="width: 735px;">
                    <div id="note" class="ps-2">
                        @if($runningText->link)
                            <a href="{{ $runningText->link }}" target="_blank">
                                <p class="text-white mb-0 link-hover">{{ $runningText->teks }}</p>
                            </a>
                        @else
                            <p class="text-white mb-0">{{ $runningText->teks }}</p>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            {{-- ====================================================== --}}
            {{-- !! PERBAIKAN UTAMA ADA DI SINI !! --}}
            {{-- ====================================================== --}}
            {{-- Kolom Kanan: Tanggal & Link Sosial --}}
            <div class="top-link d-flex align-items-center">
                {{-- Bagian Tanggal --}}
                <div class="d-flex align-items-center me-2 pe-2 border-end border-secondary">
                    <i class="fas fa-calendar-alt text-white me-2"></i>
                    <span class="text-body">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                {{-- Bagian Sosial Media --}}
                <div class="d-flex align-items-center">
                    <p class="mb-0 text-white me-2">Ikuti Kami:</p>
                    <a href="{{ $settings['sosmed_facebook'] ?? '#' }}" class="me-2"><i class="fab fa-facebook-f text-body link-hover"></i></a>
                    <a href="{{ $settings['sosmed_instagram'] ?? '#' }}" class="me-2"><i class="fab fa-instagram text-body link-hover"></i></a>
                    <a href="{{ $settings['sosmed_youtube'] ?? '#' }}" class="me-2"><i class="fab fa-youtube text-body link-hover"></i></a>
                    <a href="{{ $settings['sosmed_tiktok'] ?? '#' }}" class=""><i class="fab fa-tiktok text-body link-hover"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid sticky-top px-0">
    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light py-1">
                <div class="container-fluid">
                    {{-- Logo & Nama Puskesmas --}}
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        @if(!empty($settings['logo_puskesmas']))
                            <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}"
                                 alt="Logo Puskesmas"
                                 style="height: 60px; margin-right: 18px;">
                        @endif
                        <div>
                            <p class="text-primary mb-0 fw-bold">{{ $settings['nama_puskesmas'] ?? 'Puskesmas' }}</p>
                            <small class="text-secondary" style="letter-spacing: 2px; line-height: 2;">
                                {{ $settings['kecamatan'] ?? 'Kecamatan' }}
                            </small>
                        </div>
                    </a>

                    {{-- Toggle Button for Mobile --}}
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>

                    {{-- Menu Utama --}}
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav mx-auto">

                            {{-- Beranda --}}
                            <li class="nav-item">
                                <a href="{{ route('home') }}"
                                   class="nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}">
                                    Beranda
                                </a>
                            </li>

                            {{-- Artikel --}}
                            <li class="nav-item">
                                <a href="{{ route('berita.semua') }}"
                                   class="nav-link fw-bold {{ request()->routeIs('berita.semua') ? 'active' : '' }}">
                                    Artikel
                                </a>
                            </li>

                            {{-- Dynamic Menu --}}
                            @foreach($klusters as $kluster)
                                @if($kluster->childrenRecursive->isNotEmpty())
                                    {{-- Mega Menu --}}
                                    <li class="nav-item dropdown position-static">
                                        <a href="#"
                                           class="nav-link dropdown-toggle fw-bold"
                                           data-bs-toggle="dropdown">
                                            {{ $kluster->title }}
                                        </a>
                                        <div class="dropdown-menu w-100 shadow border-0 rounded-0 mt-0">
                                            <div class="row px-4 py-3">
                                                @foreach($kluster->childrenRecursive as $child)
                                                    <div class="col-md-3 mega-menu-column">
                                                        <h6 class="text-uppercase">{{ $child->title }}</h6>
                                                        @foreach($child->childrenRecursive as $grandchild)
                                                            @php
                                                                $url = $grandchild->url ?? ($grandchild->halaman ? route('halaman.tampil', $grandchild->halaman->slug) : '#');
                                                            @endphp
                                                            <a class="dropdown-item" href="{{ $url }}">
                                                                {{ $grandchild->title }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    {{-- Single Menu --}}
                                    @php
                                        $url = $kluster->url ?? ($kluster->halaman ? route('halaman.tampil', $kluster->halaman->slug) : '#');
                                    @endphp
                                    <li class="nav-item">
                                        <a href="{{ $url }}" class="nav-link fw-bold">{{ $kluster->title }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        {{-- Login & Search --}}
                        <div class="d-flex align-items-center">
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 me-3">Login</a>
                            <button class="btn border border-primary btn-md-square rounded-circle bg-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#searchModal">
                                <i class="fas fa-search text-primary"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
