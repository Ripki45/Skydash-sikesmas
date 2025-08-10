<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasyarakatDashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk masyarakat.
     */
    public function index()
    {
        $today = now()->toDateString();
        $user = Auth::user();

        // Ambil ID pengumuman yang sudah dikonfirmasi oleh user ini
        $confirmedIds = $user->confirmedPengumumans()->pluck('pengumumans.id')->toArray();

        // Ambil semua pengumuman yang aktif (published dan dalam rentang tanggal)
        $pengumumans = Pengumuman::where('status', 'published')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->latest()
            ->get();

        // Kirim data ke view
        return view('masyarakat.dashboard', compact('pengumumans', 'confirmedIds'));
    }

    /**
     * Menyimpan data konfirmasi kehadiran dari pengguna.
     */
    public function konfirmasiKehadiran(Pengumuman $pengumuman)
    {
        $user = Auth::user();

        // Gunakan syncWithoutDetaching untuk menambahkan relasi tanpa duplikat
        $user->confirmedPengumumans()->syncWithoutDetaching($pengumuman->id);

        return back()->with('success', 'Terima kasih! Konfirmasi kehadiran Anda telah kami catat.');
    }
}
