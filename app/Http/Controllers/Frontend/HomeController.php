<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Banner;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Halaman;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\RunningText;
use Illuminate\Http\Request;
use App\Models\SinergiProgram;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data untuk ditampilkan di halaman depan
        $banners = Banner::orderBy('urutan_tampil')->get();
        $runningText = RunningText::where('is_active', true)->first();
        $layanans = Layanan::where('is_active', true)->orderBy('urutan')->get();
        $sinergiPrograms = SinergiProgram::where('is_active', true)->orderBy('urutan')->get();

        // REVISI TOTAL UNTUK QUERY BERITA
         $beritas = Berita::with('kategori', 'user')
                         ->where('status', 'published')
                         ->whereDate('published_at', '<=', now()) // Pastikan tanggalnya hari ini atau sebelumnya
                         ->orderBy('published_at', 'desc') // Urutkan dari yang terbaru
                         ->take(5) // Ambil 5 berita
                         ->get();

        $pengumumans = Pengumuman::where('status', 'published')
                                 ->where('tipe', 'info')
                                 ->whereDate('tanggal_selesai', '>=', now())
                                 ->latest()
                                 ->take(7) // Ambil 7 pengumuman terbaru
                                 ->get();

        // Kirim semua data ke view 'welcome'
        return view('welcome', compact(
            'banners',
            'runningText',
            'layanans',
            'sinergiPrograms',
            'beritas',
            'pengumumans' // <-- Tambahkan ini
        ));
    }

    public function showHalaman($slug)
    {
        $halaman = Halaman::where('slug', $slug)->where('status', 'published')->firstOrFail();

        // REVISI: Ambil juga data untuk layout
        $runningText = RunningText::where('is_active', true)->first();

        return view('halaman-detail', compact('halaman', 'runningText'));
    }
}
