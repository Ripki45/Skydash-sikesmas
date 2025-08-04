<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Desa;
use App\Models\Banner;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Halaman;
use App\Models\Layanan;
use App\Models\Pengumuman;
use App\Models\RunningText;
use Illuminate\Http\Request;
use App\Models\GaleriKategori;
use App\Models\JadwalPosyandu;
use App\Models\SinergiProgram;
use App\Models\TenagaKesehatan;
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

        $beritas = Berita::with('kategori', 'user')
                         ->where('status', 'published')
                         ->whereDate('published_at', '<=', now())
                         ->orderBy('published_at', 'desc')
                         ->take(10) // Ambil 10 berita untuk layout yang lebih kaya
                         ->get();

        $pengumumans = Pengumuman::where('status', 'published')
                                 ->where('tipe', 'info')
                                 ->whereDate('tanggal_selesai', '>=', now())
                                 ->latest()
                                 ->take(7)
                                 ->get();

        $tenagaKesehatans = TenagaKesehatan::latest()->get();
        $desas = Desa::all();
        $jadwals = JadwalPosyandu::with('posyandu.dusun.desa')
                                 ->whereDate('tanggal_kegiatan', '>=', now())
                                 ->orderBy('tanggal_kegiatan', 'asc')
                                 ->get();

        $galeriKategoris = GaleriKategori::has('galeris')->with('galeris')->latest()->take(5)->get();
        $galeris = Galeri::latest()->take(12)->get(); // Ambil 12 foto terbaru untuk tampilan awal


        // Kirim semua data ke view 'welcome'
        return view('welcome', compact(
            'banners',
            'runningText',
            'layanans',
            'sinergiPrograms',
            'beritas',
            'pengumumans',
            'tenagaKesehatans',
            'desas',
            'jadwals', // <-- Koma sudah ditambahkan
            'galeris',
            'galeriKategoris'
        ));
    }

    public function showHalaman($slug)
    {
        $halaman = Halaman::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('halaman-detail', compact('halaman'));
    }

    public function getJadwalByFilter(Request $request)
    {
        $query = JadwalPosyandu::with('posyandu.dusun.desa')
                        ->orderBy('tanggal_kegiatan', 'asc');

        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('tanggal_kegiatan', [$request->start, $request->end]);
        } else {
            $query->whereDate('tanggal_kegiatan', '>=', now());
        }

        if ($request->filled('desa_id')) {
            $query->whereHas('posyandu.dusun', function ($q) use ($request) {
                $q->where('desa_id', $request->desa_id);
            });
        }

        if ($request->filled('dusun_id')) {
            $query->whereHas('posyandu', function ($q) use ($request) {
                $q->where('dusun_id', $request->dusun_id);
            });
        }

        if ($request->filled('posyandu_id')) {
            $query->where('posyandu_id', $request->posyandu_id);
        }

        $jadwals = $query->get();

        $events = $jadwals->map(function ($jadwal) {
            $color = '#6c757d'; // default
            switch ($jadwal->jenis_kegiatan) {
                case 'Posyandu Balita': $color = '#28a745'; break;
                case 'Posyandu Lansia': $color = '#007bff'; break;
                case 'Posyandu Remaja': $color = '#e83e8c'; break;
                case 'Posbindu PTM': $color = '#ffc107'; break;
            }

            return [
                'title' => $jadwal->nama_kegiatan,
                'start' => $jadwal->tanggal_kegiatan->toDateString(),
                'allDay' => true,
                'color' => $color,
                'extendedProps' => [
                    'jenis' => $jadwal->jenis_kegiatan,
                    'posyandu' => $jadwal->posyandu->nama_posyandu,
                    'dusun' => $jadwal->posyandu->dusun->nama_dusun,
                ]
            ];
        });

        $listHtml = view('partials._jadwal-list', ['jadwals' => $jadwals])->render();

        return response()->json([
            'events' => $events,
            'list_html' => $listHtml,
        ]);
    }
}
