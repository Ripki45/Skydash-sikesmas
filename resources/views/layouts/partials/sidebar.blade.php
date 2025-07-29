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
        <p style="color: #999; font-size: 0.8rem; padding-top: 1rem; padding-bottom: 0;">DATA MASTER</p>
    </li>

    {{-- MENU PUSTU BARU --}}
    <li class="nav-item">
      <a class="nav-link" href="{{ route('pustu.index') }}">
        <i class="mdi mdi-hospital-building menu-icon"></i>
        <span class="menu-title">Puskemas Pembantu</span>
      </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="mdi mdi-account-multiple-outline menu-icon"></i>
            <span class="menu-title">Manajemen Pengguna</span>
        </a>
    </li>

    {{-- PEMISAH LAMA --}}
    <li class="nav-item">
        <hr class="mt-2 mb-1">
        <p style="color: #999; font-size: 0.8rem; padding-top: 1rem; padding-bottom: 0;">PENGATURAN WEBSITE</p>
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
          <li class="nav-item"> <a class="nav-link" href="{{ route('galeri.index') }}">Galeri</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
        </ul>
      </div>
    </li>
    {{-- MENU DROPDOWN BARU UNTUK WILAYAH & PUSTU --}}
    <li class="nav-item">
    <a class="nav-link" data-toggle="collapse" href="#wilayah-kerja" aria-expanded="false" aria-controls="wilayah-kerja">
        <i class="mdi mdi-map-marker-radius menu-icon"></i>
        <span class="menu-title">Wilayah & Pustu</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="collapse" id="wilayah-kerja">
        <ul class="nav flex-column sub-menu">
        <li class="nav-item"> <a class="nav-link" href="{{ route('desa.index') }}">Manajemen Desa</a></li>
        <li class="nav-item"> <a class="nav-link" href="{{ route('dusun.index') }}">Manajemen Dusun</a></li>
        <li class="nav-item"> <a class="nav-link" href="{{ route('pustu.index') }}">Manajemen Pustu</a></li>
        </ul>
    </div>
    </li>
  </ul>
</nav>
