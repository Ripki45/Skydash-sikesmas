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

    {{-- PEMISAH --}}
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
          <li class="nav-item"> <a class="nav-link" href="{{ route('galeri.index') }}">Galeri</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Pengumuman</a></li>
        </ul>
      </div>
    </li>

  </ul>
</nav>
