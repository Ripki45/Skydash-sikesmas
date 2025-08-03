<!-- Navbar start -->
<div class="container-fluid sticky-top px-0">
    <div class="container-fluid topbar bg-dark d-none d-lg-block">
        <div class="container px-0">
            <div class="topbar-top d-flex justify-content-between flex-lg-wrap">
                <div class="top-info flex-grow-0">
                    <span class="rounded-circle btn-sm-square bg-primary me-2">
                        <i class="fas fa-bolt text-white"></i>
                    </span>
                    <div class="pe-2 me-3 border-end border-white d-flex align-items-center">
                        <p class="mb-0 text-white fs-6 fw-normal">Info</p>
                    </div>
                    {{-- Menampilkan Running Text Dinamis --}}
                    @if($runningText)
                        <div class="overflow-hidden" style="width: 735px;">
                            <div id="note" class="ps-2">
                                <a href="{{ $runningText->link ?? '#' }}" target="_blank"><p class="text-white mb-0 link-hover">{{ $runningText->teks }}</p></a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="top-link flex-lg-wrap">
                    <i class="fas fa-calendar-alt text-white border-end border-secondary pe-2 me-2">
                        {{-- Menampilkan tanggal hari ini --}}
                        <span class="text-body text-white ">{{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}</span>
                    </i>
                </div>
            </div>
        </div>
    </div>
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
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="text-primary display-6">Puskesmas</span><br>
                    <small class="text-secondary">NAMA KECAMATAN</small>
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
                                                                $url = $grandchild->url ?? ($grandchild->halaman ? route('halaman.show', $grandchild->halaman->slug) : '#');
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
                                    $url = $kluster->url ?? ($kluster->halaman ? route('halaman.show', $kluster->halaman->slug) : '#');
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
