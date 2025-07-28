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
        <span class="menu-title">Pengaturan Website</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="pengaturan-website">
        <ul class="nav flex-column sub-menu">
          {{-- Nanti kita akan isi href ini dengan route yang benar --}}
          <li class="nav-item"> <a class="nav-link" href="{{ route('kluster.index') }}">Kluster</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{ route('halaman.index') }}">Halaman</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Banner</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Layanan</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Sinergi Program</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Galeri</a></li>
          <li class="nav-item"> <a class="nav-link" href="#">Pengumuman</a></li>
        </ul>
      </div>
    </li>

  </ul>
</nav>
