<?php

use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\GaleriKategoriController;
use App\Http\Controllers\JadwalPosyanduController;
use App\Http\Controllers\SinergiProgramController;
use App\Http\Controllers\SkriningSkilasController;
use App\Http\Controllers\TenagaKesehatanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/artikel', [HomeController::class, 'semuaBerita'])->name('berita.semua');
Route::get('/artikel/{berita:slug}', [HomeController::class, 'showBerita'])->name('artikel.show');
Route::get('/lihat/{halaman:slug}', [HomeController::class, 'tampilHalamanPublik'])->name('halaman.tampil');



Route::get('/api/jadwal', [HomeController::class, 'getJadwalByFilter'])->name('api.jadwal.filter');
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //route untuk login
    Route::resource('users', UserController::class);
    Route::get('/api/dusuns/{desa}', [App\Http\Controllers\UserController::class, 'getDusunsByDesa'])->name('api.dusuns.by.desa');
    Route::get('/api/posyandus/{dusun}', [App\Http\Controllers\UserController::class, 'getPosyandusByDusun'])->name('api.posyandus.by.dusun');
    Route::get('/api/posyandus/{dusun}', [App\Http\Controllers\UserController::class, 'getPosyandusByDusun'])->name('api.posyandus.by.dusun');

    //ini untuk data wilayah kerja
    Route::resource('halaman', HalamanController::class);
    Route::resource('desa', DesaController::class);
    Route::resource('dusun', DusunController::class);
    Route::resource('posyandu', PosyanduController::class);
    Route::resource('pustu', PustuController::class);

    Route::resource('kluster', KlusterController::class);
    Route::resource('skrining-skilas', SkriningSkilasController::class);



    Route::resource('banner', BannerController::class);
    // Untuk running text, kita buat rute khusus karena manajemennya lebih simpel
    Route::post('running-text/update', [BannerController::class, 'updateRunningText'])->name('running-text.update');
    Route::resource('layanan', LayananController::class);
    Route::resource('sinergi-program', SinergiProgramController::class);
    Route::resource('galeri', GaleriController::class);
    Route::resource('galeri-kategori', GaleriKategoriController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('tenaga-kesehatan', TenagaKesehatanController::class);
    Route::resource('jadwal-posyandu', JadwalPosyanduController::class);

    //berita
    Route::resource('kategori', KategoriController::class);
    Route::resource('tag', TagController::class);
    Route::resource('berita', BeritaController::class)->parameters([
    'berita' => 'berita'
    ]);



    //manajemen puskesmas

    });
    // Tambahkan baris ini untuk Beranda



require __DIR__.'/auth.php';
