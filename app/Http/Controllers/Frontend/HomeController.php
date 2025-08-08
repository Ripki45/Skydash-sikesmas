<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use App\Models\Desa;
use App\Models\Banner;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Halaman;
use App\Models\Layanan;
use App\Models\Kategori;
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

    public function tampilHalamanPublik(Halaman $halaman)
    {
        // Pastikan halaman yang diminta sudah di-publish
        if ($halaman->status !== 'published') {
            abort(404);
        }

        $beritaTerbaru = Berita::where('status', 'published')
                            ->whereDate('published_at', '<=', now())
                            ->latest('published_at')
                            ->take(5)
                            ->get();

        return view('halaman-detail', compact('halaman', 'beritaTerbaru'));
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
    public function semuaBerita()
    {
        // 1. Ambil semua berita utama dengan pagination
        $beritas = Berita::with('kategori', 'user')
                        ->where('status', 'published')
                        ->whereDate('published_at', '<=', now())
                        ->orderBy('published_at', 'desc')
                        ->paginate(9); // 9 berita per halaman

        // 2. Ambil semua kategori untuk sidebar
        $kategoris = Kategori::has('beritas')->withCount('beritas')->get();

        // 3. Ambil layanan untuk carousel di sidebar
        $layanans = Layanan::where('is_active', true)->orderBy('urutan')->get();

        // 4. Ambil tags yang paling banyak digunakan (trending)
        $trendingTags = Tag::has('beritas')->withCount('beritas')->orderBy('beritas_count', 'desc')->take(10)->get();

        // 5. Kirim semua data ke view
        return view('berita', compact('beritas', 'kategoris', 'layanans', 'trendingTags'));
    }

    public function showBerita(Berita $berita)
    {
        // Pastikan berita yang diakses sudah di-publish
        if ($berita->status !== 'published' || $berita->published_at > now()) {
            abort(404);
        }

        // Ambil data untuk sidebar
        $kategoris = Kategori::has('beritas')->withCount('beritas')->get();
        $trendingTags = Tag::has('beritas')->withCount('beritas')->orderBy('beritas_count', 'desc')->take(10)->get();
        $beritaTerkait = Berita::where('kategori_id', $berita->kategori_id)
                                ->where('id', '!=', $berita->id) // Jangan tampilkan berita yang sedang dibaca
                                ->where('status', 'published')
                                ->latest('published_at')
                                ->take(2)
                                ->get();

        return view('berita-detail', compact('berita', 'kategoris', 'trendingTags', 'beritaTerkait'));
    }

}
