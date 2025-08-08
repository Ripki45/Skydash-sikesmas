<!-- Navbar start -->
<div class="container-fluid sticky-top px-0">
    {{-- <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-expand-xl navbar-light bg-light sticky-top py-3">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <span class="text-primary display-6">Newsers</span><br>
                        <small class="text-secondary">Nespaper</small>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="#" class="nav-item nav-link active">Beranda</a>
                            <a href="#" class="nav-item nav-link">Detail Page</a>
                            <a href="#" class="nav-item nav-link">404 Page</a>

                            <!-- Mega Menu Item -->
                            <div class="nav-item dropdown position-static">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Integrasi Layanan Primer</a>
                            <div class="dropdown-menu w-100 shadow mt-0 border-0 rounded-0">
                                <div class="row px-4 py-3">
                                    <div class="col-md-3 mega-menu-column">
                                        <h6 class="text-uppercase fw-bold">Klaster Manajemen</h6>
                                        <a class="dropdown-item" href="#">Manajemen Inti</a>
                                        <a class="dropdown-item" href="#">Manajemen Arsip</a>
                                        <a class="dropdown-item" href="#">SDM</a>
                                        <a class="dropdown-item" href="#">Sarana dan Prasarana</a>
                                    </div>
                                    <div class="col-md-3 mega-menu-column">
                                        <h6 class="text-uppercase fw-bold">Kesehatan Ibu dan Anak</h6>
                                        <a class="dropdown-item" href="#">Ibu Hamil</a>
                                        <a class="dropdown-item" href="#">Balita & Anak Pra Sekolah</a>
                                        <a class="dropdown-item" href="#">Remaja</a>
                                    </div>
                                    <div class="col-md-3 mega-menu-column">
                                        <h6 class="text-uppercase fw-bold">Usia Dewasa & Lansia</h6>
                                        <a class="dropdown-item" href="#">Usia Dewasa</a>
                                        <a class="dropdown-item" href="#">Lansia</a>
                                    </div>
                                    <div class="col-md-3 mega-menu-column">
                                        <h6 class="text-uppercase fw-bold">Dukungan Pelayanan</h6>
                                        <a class="dropdown-item" href="#">Gawat Darurat</a>
                                        <a class="dropdown-item" href="#">Rehabilitasi Medik</a>
                                        <a class="dropdown-item" href="#">Kefarmasian</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <a href="#" class="nav-item nav-link">Contact Us</a>
                        </div>

                    <!-- Right side (weather/search) -->
                    <div class="d-flex align-items-center border-top pt-3 pt-xl-0">
                        <div class="d-flex align-items-center me-3">
                        <img src="img/weather-icon.png" class="img-fluid me-2" style="width: 32px;" alt="">
                        <div>
                            <strong class="fs-5 text-secondary">31°C</strong><br>
                            <small class="text-muted">NEW YORK,<br>Mon. 10 jun 2024</small>
                        </div>
                        </div>
                        <button class="btn border border-primary btn-md-square rounded-circle bg-white" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="fas fa-search text-primary"></i>
                        </button>
                    </div>
                    </div>
                </div>
            </nav>
        </div>
    </div> --}}


    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-expand-xl navbar-light bg-light sticky-top py-3">
                <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        {{-- Tampilkan logo jika ada --}}
                        @if(isset($settings['logo_puskesmas']) && $settings['logo_puskesmas'])
                            <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" alt="Logo Puskesmas" style="height: 75px; margin-right: 20px;">
                        @endif
                        <div>
                                    {{-- Tampilkan nama puskesmas dan kecamatan --}}
                            <p class="text-primary mb-0 display-6">{{ $settings['nama_puskesmas'] ?? 'Puskesmas' }}</p>
                            <small class="text-secondary" style="letter-spacing: 2px; line-height: 2;">{{ $settings['kecamatan'] ?? 'Kecamatan' }}</small>
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">

                            {{-- =============================================== --}}
                            {{-- REVISI UTAMA: NAVIGASI DINAMIS DENGAN MEGA MENU --}}
                            {{-- =============================================== --}}
                            <a href="{{ route('home') }}" class="nav-item nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                            <a href="{{ route('berita.semua') }}" class="nav-item nav-link fw-bold {{ request()->routeIs('berita.semua') ? 'active' : '' }}">Artikel</a>
                            @foreach($klusters as $kluster)
                                {{-- Cek apakah menu ini adalah menu induk yang punya sub-menu --}}
                                @if($kluster->childrenRecursive->isNotEmpty())
                                    <div class="nav-item dropdown position-static">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $kluster->title }}</a>
                                        <div class="dropdown-menu w-100 shadow mt-0 border-0 rounded-0">
                                            <div class="row px-4 py-3">
                                                {{-- Loop untuk setiap sub-menu (anak) sebagai kolom --}}
                                                @foreach($kluster->childrenRecursive as $child)
                                                    <div class="col-md-3 mega-menu-column">
                                                        <h6 class="text-uppercase">{{ $child->title }}</h6>
                                                        {{-- Cek apakah sub-menu ini punya anak-anaknya (cicit) --}}
                                                        @if($child->childrenRecursive->isNotEmpty())
                                                            @foreach($child->childrenRecursive as $grandchild)
                                                                @php
                                                                    $url = $grandchild->url ?? ($grandchild->halaman ? route('halaman.tampil', $grandchild->halaman->slug) : '#');
                                                                @endphp
                                                                <a class="dropdown-item" href="{{ $url }}">{{ $grandchild->title }}</a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Jika ini menu tunggal (tidak punya anak) --}}
                                    @php
                                        $url = $kluster->url ?? ($kluster->halaman ? route('halaman.tampil', $kluster->halaman->slug) : '#');
                                    @endphp
                                    <a href="{{ $url }}" class="nav-item nav-link">{{ $kluster->title }}</a>
                                @endif
                            @endforeach
                            {{-- =============================================== --}}
                        </div>

                        <div class="d-flex align-items-center border-top pt-3 pt-xl-0">
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 me-3">Login</a>
                            <button class="btn border border-primary btn-md-square rounded-circle bg-white" data-bs-toggle="modal" data-bs-target="#searchModal">
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

