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
    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-light navbar-expand-xl">
                <a href="{{ route('home') }}" class="navbar-brand mt-3">
                    <p class="text-primary display-6 mb-2" style="line-height: 0;">Puskesmas</p>
                    <small class="text-body fw-normal" style="letter-spacing: 8px;">NAMA PUSKESMAS</small>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-light py-3" id="navbarCollapse">
                    <div class="navbar-nav mx-auto border-top">

                        {{-- =============================================== --}}
                        {{-- REVISI UTAMA: NAVIGASI DINAMIS DARI BACKEND --}}
                        {{-- =============================================== --}}
                        <a href="{{ route('home') }}" class="nav-item nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                        @foreach($klusters as $kluster)
                            {{-- Jika menu punya sub-menu (anak) --}}
                            @if($kluster->children->isNotEmpty())
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $kluster->title }}</a>
                                    <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                        @foreach($kluster->children as $child)
                                            {{-- Cek link untuk sub-menu --}}
                                            @php
                                                $childUrl = '#'; // Default URL jika tidak ada link
                                                if ($child->url) {
                                                    $childUrl = $child->url;
                                                } elseif ($child->halaman) {
                                                    $childUrl = route('halaman.show', $child->halaman->slug);
                                                }
                                            @endphp
                                            <a href="{{ $childUrl }}" class="dropdown-item">{{ $child->title }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                {{-- Jika menu tunggal --}}
                                @php
                                    $klusterUrl = '#'; // Default URL jika tidak ada link
                                    if ($kluster->url) {
                                        $klusterUrl = $kluster->url;
                                    } elseif ($kluster->halaman) {
                                        $klusterUrl = route('halaman.show', $kluster->halaman->slug);
                                    }
                                @endphp
                                <a href="{{ $klusterUrl }}" class="nav-item nav-link">{{ $kluster->title }}</a>
                            @endif
                        @endforeach
                        {{-- =============================================== --}}

                    </div>
                    <div class="d-flex flex-nowrap border-top pt-3 pt-xl-0">
                        {{-- TOMBOL LOGIN BARU --}}
                        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill text-white py-2 px-4 me-2">Login</a>

                        <button class="btn-search btn border border-primary btn-md-square rounded-circle bg-white my-auto" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
