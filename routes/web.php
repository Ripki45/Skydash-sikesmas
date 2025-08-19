<?php

use Illuminate\Support\Facades\Route;

// Impor semua controller di satu tempat agar rapi
use App\Http\Controllers\TagController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\PustuController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\KlusterController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\GaleriKategoriController;
use App\Http\Controllers\JadwalPosyanduController;
use App\Http\Controllers\SinergiProgramController;
use App\Http\Controllers\SkriningSkilasController;
use App\Http\Controllers\TenagaKesehatanController;
use App\Http\Controllers\JadwalMasyarakatController;
use App\Http\Controllers\DependentDropdownController;
use App\Http\Controllers\KalkulatorKesehatanController;
use App\Http\Controllers\MasyarakatDashboardController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK
| Rute yang dapat diakses oleh semua pengunjung tanpa perlu login.
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artikel', [HomeController::class, 'semuaBerita'])->name('berita.semua');
Route::get('/artikel/{berita:slug}', [HomeController::class, 'showBerita'])->name('artikel.show');
Route::get('/lihat/{halaman:slug}', [HomeController::class, 'tampilHalamanPublik'])->name('halaman.tampil');
Route::get('/api/jadwal', [HomeController::class, 'getJadwalByFilter'])->name('api.jadwal.filter');
Route::post('/get-dusuns', [DependentDropdownController::class, 'getDusuns'])->name('getDusuns');
Route::post('/api/get-dusuns', [DependentDropdownController::class, 'getDusuns'])->name('api.getDusuns');
Route::post('/api/get-posyandus', [DependentDropdownController::class, 'getPosyandus'])->name('api.getPosyandus');
Route::get('/pengumuman', [HomeController::class, 'semuaPengumuman'])->name('pengumuman.semua');
Route::get('/pengumuman/{pengumuman:slug}', [HomeController::class, 'showPengumuman'])->name('pengumuman.show');
// Rute Otentikasi Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


/*
|--------------------------------------------------------------------------
| 2. RUTE YANG MEMBUTUHKAN OTENTIKASI
| Semua rute di dalam grup ini hanya bisa diakses setelah pengguna login.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Utama (akan me-redirect berdasarkan peran)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Profil Pengguna (berlaku untuk semua peran)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | 2A. GRUP RUTE ADMIN & STAF
    | Hanya bisa diakses oleh peran selain 'Masyarakat'.
    | URL akan diawali dengan /admin/...
    | Nama rute akan diawali dengan admin.
    |--------------------------------------------------------------------------
    */
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => ['role:Super Administrator|Penulis|Bidan|Ketua Posyandu|Anggota Posyandu']
    ], function () {

        // Manajemen Inti
        Route::resource('users', UserController::class);
        Route::resource('pengumuman', PengumumanController::class);
        Route::resource('settings', SettingController::class)->only(['index', 'update']);

        // Manajemen Konten
        Route::resource('berita', BeritaController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('tag', TagController::class);
        Route::resource('halaman', HalamanController::class);
        Route::resource('banner', BannerController::class);
        Route::resource('galeri', GaleriController::class);
        Route::resource('galeri-kategori', GaleriKategoriController::class);

        // Manajemen Layanan & Jadwal
        Route::resource('layanan', LayananController::class);
        Route::resource('jadwal-posyandu', JadwalPosyanduController::class);
        Route::resource('skrining-skilas', SkriningSkilasController::class);

        // Manajemen Wilayah & SDM
        Route::resource('desa', DesaController::class);
        Route::resource('dusun', DusunController::class);
        Route::resource('posyandu', PosyanduController::class);
        Route::resource('pustu', PustuController::class);
        Route::resource('tenaga-kesehatan', TenagaKesehatanController::class);

        // Rute Lainnya
        Route::resource('kluster', KlusterController::class);
        Route::resource('sinergi-program', SinergiProgramController::class);
        Route::post('running-text/update', [BannerController::class, 'updateRunningText'])->name('running-text.update');

        // Rute untuk API Dropdown Dinamis
        Route::post('/get-dusuns-by-desa', [DependentDropdownController::class, 'getDusuns'])->name('getDusunsByDesa');
        Route::post('/get-posyandus-by-dusun', [DependentDropdownController::class, 'getPosyandus'])->name('getPosyandusByDusun');
    });


   Route::group([
    'prefix' => 'user',
    'as' => 'masyarakat.',
    'middleware' => ['role:Masyarakat']
], function () {
    Route::get('/dashboard', [MasyarakatDashboardController::class, 'index'])->name('dashboard');
    Route::post('/pengumuman/{pengumuman}/konfirmasi', [MasyarakatDashboardController::class, 'konfirmasiKehadiran'])->name('pengumuman.konfirmasi');


    // Rute untuk menampilkan halaman jadwal
    Route::get('/jadwal', [JadwalMasyarakatController::class, 'index'])->name('jadwal.index');

    // Rute untuk menangani aksi konfirmasi kehadiran
    Route::post('/jadwal/{jadwal_posyandu}/konfirmasi', [JadwalMasyarakatController::class, 'konfirmasiKehadiran'])->name('jadwal.konfirmasi');
    Route::get('/jadwal/filter', [JadwalMasyarakatController::class, 'getJadwalByFilter'])->name('jadwal.filter');
    Route::get('/kalkulator', [KalkulatorKesehatanController::class, 'index'])->name('kalkulator.index');
});

});


/*
|--------------------------------------------------------------------------
| 3. RUTE OTENTIKASI BAWAAN
| File yang menangani rute login, register, lupa password, dll.
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
