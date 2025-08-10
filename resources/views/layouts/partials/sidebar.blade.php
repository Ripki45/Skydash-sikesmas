<?php $type_menu = 'vertical'; ?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- ====================================================== --}}
        {{-- MENU YANG BISA DILIHAT SEMUA PERAN (TERMASUK MASYARAKAT) --}}
        {{-- ====================================================== --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @hasrole('Masyarakat')
        <li class="nav-item"><hr class="mt-2 mb-1"></li>

        {{-- Beranda Dashboard (Pengumuman) --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('masyarakat.dashboard') }}">
                <i class="mdi mdi-bullhorn menu-icon"></i>
                <span class="menu-title">Pengumuman</span>
            </a>
        </li>

        {{-- Jadwal Layanan --}}
        <li class="nav-item">
            {{-- Nanti kita buat rute & halamannya --}}
            <a class="nav-link" href="{{ route('masyarakat.jadwal.index') }}">
                <i class="mdi mdi-calendar-clock menu-icon"></i>
                <span class="menu-title">Jadwal Layanan</span>
            </a>
        </li>

        {{-- Pojok Edukasi --}}
        <li class="nav-item">
            {{-- Nanti kita buat rute & halamannya --}}
            <a class="nav-link" href="{{ route('masyarakat.kalkulator.index') }}">
                <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                <span class="menu-title">Kalkulator</span>
            </a>
        </li>

        {{-- Sumber Daya (Dropdown) --}}
        {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#sumber-daya" aria-expanded="false" aria-controls="sumber-daya">
                <i class="mdi mdi-download menu-icon"></i>
                <span class="menu-title">Sumber Daya</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sumber-daya">
                <ul class="nav flex-column sub-menu">
                    {{-- Nanti kita buat rute & halamannya --}}
                    {{-- <li class="nav-item"> <a class="nav-link" href="#">Download Surat</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('masyarakat.kalkulator.index') }}">Kalkulator Kesehatan</a></li>
                </ul>
            </div>
        </li> --}}

        {{-- Profil Saya --}}

        @endhasrole


        {{-- ====================================================== --}}
        {{-- SEMUA MENU DI BAWAH INI HANYA UNTUK ADMIN & STAF --}}
        {{-- ====================================================== --}}
        @hasanyrole('Super Administrator|Penulis|Bidan|Ketua Posyandu|Anggota Posyandu')

        <li class="nav-item"><hr class="mt-2 mb-1"></li>

        {{-- MENU MANAJEMEN INTI (HANYA SUPER ADMIN) --}}
        @hasrole('Super Administrator')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.settings.index') }}">
                <i class="mdi mdi-cogs menu-icon"></i>
                <span class="menu-title">Profil Puskesmas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="mdi mdi-account-multiple-outline menu-icon"></i>
                <span class="menu-title">Manajemen Pengguna</span>
            </a>
        </li>
        @endhasrole

        {{-- MENU MANAJEMEN SDM (SUPER ADMIN & BIDAN) --}}
        @hasanyrole('Super Administrator|Bidan')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.tenaga-kesehatan.index') }}">
                <i class="mdi mdi-account-card-details menu-icon"></i>
                <span class="menu-title">Manajemen SDM</span>
            </a>
        </li>
        @endhasanyrole

        {{-- MENU SKRINING (SEMUA STAF KECUALI PENULIS) --}}
        @hasanyrole('Super Administrator|Bidan|Ketua Posyandu|Anggota Posyandu')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.skrining-skilas.index') }}">
                <i class="mdi mdi-file-document-box-multiple-outline menu-icon"></i>
                <span class="menu-title">Skrining SKILAS</span>
            </a>
        </li>
        @endhasanyrole

        <li class="nav-item"><hr class="mt-2 mb-1"></li>

        {{-- MENU PENGATURAN BERANDA (HANYA SUPER ADMIN) --}}
        @hasrole('Super Administrator')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#pengaturan-website" aria-expanded="false" aria-controls="pengaturan-website">
                <i class="icon-cog menu-icon"></i>
                <span class="menu-title">Beranda</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pengaturan-website">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.kluster.index') }}">Kluster</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.halaman.index') }}">Halaman</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.banner.index') }}">Banner</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.layanan.index') }}">Layanan</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.sinergi-program.index') }}">Sinergi Program</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.pengumuman.index') }}">Pengumuman</a></li>
                </ul>
            </div>
        </li>
        @endhasrole

        {{-- MENU WILAYAH KERJA (SUPER ADMIN & BIDAN) --}}
        @hasanyrole('Super Administrator|Bidan')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#wilayah-kerja" aria-expanded="false" aria-controls="wilayah-kerja">
                <i class="mdi mdi-map-marker-radius menu-icon"></i>
                <span class="menu-title">Wilayah Kerja</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="wilayah-kerja">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.desa.index') }}">Desa</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.dusun.index') }}">Dusun</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.pustu.index') }}">Pustu</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.posyandu.index') }}">Posyandu</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.jadwal-posyandu.index') }}">Jadwal Posyandu</a></li>
                </ul>
            </div>
        </li>
        @endhasanyrole

        {{-- MENU BERITA (SUPER ADMIN & PENULIS) --}}
        @hasanyrole('Super Administrator|Penulis')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#berita" aria-expanded="false" aria-controls="berita">
                <i class="mdi mdi-newspaper menu-icon"></i>
                <span class="menu-title">Berita</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="berita">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.berita.index') }}">Semua Berita</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.berita.create') }}">Buat Berita Baru</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.kategori.index') }}">Kategori</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.tag.index') }}">Tags</a></li>
                </ul>
            </div>
        </li>
        @endhasanyrole

        {{-- MENU GALERI (SUPER ADMIN & PENULIS) --}}
        @hasanyrole('Super Administrator|Penulis')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#galeri" aria-expanded="false" aria-controls="galeri">
                <i class="mdi mdi-image-multiple menu-icon"></i>
                <span class="menu-title">Manajemen Galeri</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="galeri">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.galeri.index') }}">Semua Foto</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('admin.galeri-kategori.index') }}">Kategori Galeri</a></li>
                </ul>
            </div>
        </li>
        @endhasanyrole

        @endhasanyrole
    </ul>
</nav>
