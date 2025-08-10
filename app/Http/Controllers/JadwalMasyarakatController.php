<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\JadwalPosyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMasyarakatController extends Controller
{
    /**
     * Menampilkan halaman jadwal posyandu untuk masyarakat.
     * Ini adalah "Otak Utama" yang baru.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ambil ID jadwal yang sudah dikonfirmasi oleh user ini (tetap dibutuhkan)
        $confirmedIds = $user->confirmedJadwals->pluck('id')->toArray();

        // Ambil semua data Desa untuk dropdown filter
        $desas = Desa::all();

        // PERBAIKAN #1: Kirim koleksi kosong untuk jadwal awal
        $jadwals = collect();

        return view('masyarakat.jadwal.index', compact('jadwals', 'confirmedIds', 'desas'));
    }

    /**
     * Mengambil data jadwal berdasarkan filter (untuk AJAX).
     * Versi ini hanya mengembalikan data jika ada filter yang aktif.
     */
    public function getJadwalByFilter(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $confirmedIds = $user->confirmedJadwals->pluck('id')->toArray();

        // PERBAIKAN #2: Cek apakah ada filter yang dipilih
        if (!$request->filled('desa_id') && !$request->filled('dusun_id') && !$request->filled('posyandu_id')) {
            // Jika tidak ada filter, kembalikan data kosong
            $jadwals = collect();
            $events = [];
        } else {
            // Jika ada filter, jalankan query seperti biasa
            $query = JadwalPosyandu::with('posyandu.dusun.desa')->orderBy('tanggal_kegiatan', 'asc');

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

            // Batasi hanya jadwal yang akan datang
            $query->whereDate('tanggal_kegiatan', '>=', now());

            $jadwals = $query->get();

            $events = $jadwals->map(function ($jadwal) {
            $color = '#6c757d'; // Warna default
            switch ($jadwal->jenis_kegiatan) {
                case 'Posyandu Balita': $color = '#28a745'; break;
                case 'Posyandu Lansia': $color = '#007bff'; break;
                case 'Posyandu Remaja': $color = '#e83e8c'; break;
                case 'Posbindu PTM': $color = '#ffc107'; break;
            }

            return [
                // !! PERBAIKAN UTAMA ADA DI SINI !!
                // Ganti 'kegiatan' menjadi 'nama_kegiatan'
                'title' => $jadwal->nama_kegiatan,

                'start' => $jadwal->tanggal_kegiatan,
                'allDay' => true,
                'color' => $color,
                'extendedProps' => [
                    'jenis' => $jadwal->jenis_kegiatan,
                    'posyandu' => $jadwal->posyandu->nama_posyandu ?? '-',
                    'dusun' => $jadwal->posyandu->dusun->nama_dusun ?? '-',
                ]
            ];
        });
        }

        // Render daftar jadwal (akan menampilkan pesan 'empty' jika $jadwals kosong)
        $listHtml = view('masyarakat.jadwal._jadwal-list', compact('jadwals', 'confirmedIds'))->render();

        return response()->json([
            'events' => $events,
            'list_html' => $listHtml,
        ]);
    }


    /**
     * Menyimpan data konfirmasi kehadiran dari pengguna.
     * (Method ini tetap sama)
     */
    public function konfirmasiKehadiran(JadwalPosyandu $jadwal_posyandu)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->confirmedJadwals()->syncWithoutDetaching($jadwal_posyandu->id);
        return back()->with('success', 'Terima kasih! Kehadiran Anda telah kami catat.');
    }
}
