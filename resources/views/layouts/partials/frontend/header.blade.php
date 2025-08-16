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
