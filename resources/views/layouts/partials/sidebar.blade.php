<?php $type_menu = 'vertical'; ?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">

    {{-- MENU DASHBOARD --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
   {{-- PEMISAH BARU --}}
    <li class="nav-item">
        <hr class="mt-2 mb-1">
    </li>

    {{-- MENU PUSTU BARU --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('settings.index') }}">
            <i class="mdi mdi-cogs menu-icon"></i>
            <span class="menu-title">Profil Puskesmas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="mdi mdi-account-multiple-outline menu-icon"></i>
            <span class="menu-title">Manajemen Pengguna</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('tenaga-kesehatan.index') }}">
            <i class="mdi mdi-account-card-details menu-icon"></i>
            <span class="menu-title">Manajemen SDM</span>
        </a>
    </li>

    {{-- PEMISAH LAMA --}}
    <li class="nav-item">
        <hr class="mt-2 mb-1">
    </li>
    {{-- MENU PENGATURAN WEBSITE (BARU) --}}
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#pengaturan-website" aria-expanded="false" aria-controls="pengaturan-website">
            <i class="icon-cog menu-icon"></i>
            <span class="menu-title">Beranda</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="pengaturan-website">
            <ul class="nav flex-column sub-menu">
            {{-- Nanti kita akan isi href ini dengan route yang benar --}}
            <li class="nav-item"> <a class="nav-link" href="{{ route('kluster.index') }}">Kluster</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('halaman.index') }}">Halaman</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('banner.index') }}">Banner</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('layanan.index') }}">Layanan</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('sinergi-program.index') }}">Sinergi Program</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
            </ul>
        </div>
    </li>
    {{-- MENU DROPDOWN BARU UNTUK WILAYAH & PUSTU --}}
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#wilayah-kerja" aria-expanded="false" aria-controls="wilayah-kerja">
            <i class="mdi mdi-map-marker-radius menu-icon"></i>
            <span class="menu-title">Wilayah Kerja</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="wilayah-kerja">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('desa.index') }}">Desa</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('dusun.index') }}">Dusun</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('pustu.index') }}">Pustu</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('posyandu.index') }}">Posyandu</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('jadwal-posyandu.index') }}">Jadwal Posyandu</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#berita" aria-expanded="false" aria-controls="berita">
            <i class="mdi mdi-newspaper menu-icon"></i>
            <span class="menu-title">Berita</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="berita">
            <ul class="nav flex-column sub-menu">
            {{-- Kita akan isi href ini nanti --}}
            <li class="nav-item"> <a class="nav-link" href="{{ route('berita.index') }}">Semua Berita</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('berita.create') }}">Buat Berita Baru</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('kategori.index') }}">Kategori</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('tag.index') }}">Tags</a></li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#galeri" aria-expanded="false" aria-controls="galeri">
            <i class="mdi mdi-image-multiple menu-icon"></i>
            <span class="menu-title">Manajemen Galeri</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="galeri">
            <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('galeri.index') }}">Semua Foto</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('galeri-kategori.index') }}">Kategori Galeri</a></li>
            </ul>
        </div>
    </li>

  </ul>
</nav>
