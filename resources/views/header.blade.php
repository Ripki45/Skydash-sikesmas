<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        {{-- Tampilan saat sidebar tidak diciutkan (expanded) --}}
        <a class="navbar-brand brand-logo mr-5" href="{{ route('dashboard') }}" style="display: flex; align-items: center; text-decoration: none; color: inherit;">
            @if(!empty($settings['logo_puskesmas']))
                <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" class="mr-3" alt="logo" style="height: 40px; width: auto;">
            @endif
            <div style="text-align: left; line-height: 1.2;">
                <h5 class="mb-0" style="font-weight: 600; font-size: 0.9rem;">{{ Str::limit($settings['nama_puskesmas'] ?? 'Puskesmas', 15) }}</h5>
                <small class="text-muted" style="font-size: 0.75rem;">{{ $settings['kecamatan'] ?? '' }}</small>
            </div>
        </a>

        {{-- Tampilan saat sidebar diciutkan (mini) --}}
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
            @if(!empty($settings['logo_puskesmas']))
                {{-- REVISI UTAMA: Menambahkan CSS langsung di dalam tag img --}}
                <img src="{{ asset('storage/' . $settings['logo_puskesmas']) }}" alt="logo"
                    style="width: 40px !important; height: 40px !important; object-fit: contain !important;">
            @else
                {{-- Fallback ke logo mini default dari template --}}
                <img src="{{ asset('images/logo-mini.svg') }}" alt="logo"/>
            @endif
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                {{-- Bagian search bar kita biarkan dulu --}}
                <div class="input-group">
                    <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                        <span class="input-group-text" id="search"><i class="icon-search"></i></span>
                    </div>
                    <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="btn btn-primary btn-sm d-flex align-items-center" target="_blank">
                    <i class="mdi mdi-web" style="font-size: 1.2rem; margin-right: 8px;"></i>
                    Lihat Website
                </a>
            </li>
            <li class="nav-item dropdown">
                {{-- Bagian notifikasi kita biarkan statis untuk sekarang --}}
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="icon-bell mx-0"></i>
                    <span class="count"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                    {{-- Contoh notifikasi... --}}
                </div>
            </li>
            <li class="nav-item nav-profile dropdown">
                {{-- REVISI: Menampilkan data pengguna yang sedang login --}}
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    {{-- Kita bisa ganti src ini nanti jika ada fitur upload foto profil --}}
                    <img src="{{ asset('images/faces/user.png') }}" alt="poto profil"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="ti-settings text-primary"></i>
                        Settings
                    </a>
                    {{-- REVISI: Membuat fungsi Logout yang benar --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>
                    </form>
                </div>
            </li>
            <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="#">
                    <i class="icon-ellipsis"></i>
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
