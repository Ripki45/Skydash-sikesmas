<!-- Navbar start -->
<div class="container-fluid sticky-top px-0">
    <div class="container-fluid bg-light">
        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top py-1">
                <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        @if(isset($settings['logo_puskesmas']) && $settings['logo_puskesmas'])
                            <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" alt="Logo Puskesmas" style="height: 60px; margin-right: 18px;">
                        @endif
                        <div>
                            <p class="text-primary mb-0 fw-bold">{{ $settings['nama_puskesmas'] ?? 'Puskesmas' }}</p>
                            <small class="text-secondary" style="letter-spacing: 2px; line-height: 2;">{{ $settings['kecamatan'] ?? 'Kecamatan' }}</small>
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">

                            <a href="{{ route('home') }}" class="nav-item nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>

                            {{-- INILAH PERBAIKANNYA --}}
                            {{-- Hapus 'admin.' dari nama rute --}}
                            <a href="{{ route('berita.semua') }}" class="nav-item nav-link fw-bold {{ request()->routeIs('berita.semua') ? 'active' : '' }}">Artikel</a>

                            @foreach($klusters as $kluster)
                                @if($kluster->childrenRecursive->isNotEmpty())
                                    <div class="nav-item dropdown position-static">
                                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ $kluster->title }}</a>
                                        <div class="dropdown-menu w-100 shadow mt-0 border-0 rounded-0">
                                            <div class="row px-4 py-3">
                                                @foreach($kluster->childrenRecursive as $child)
                                                    <div class="col-md-3 mega-menu-column">
                                                        <h6 class="text-uppercase">{{ $child->title }}</h6>
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
                                    @php
                                        $url = $kluster->url ?? ($kluster->halaman ? route('halaman.tampil', $kluster->halaman->slug) : '#');
                                    @endphp
                                    <a href="{{ $url }}" class="nav-item nav-link">{{ $kluster->title }}</a>
                                @endif
                            @endforeach
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
