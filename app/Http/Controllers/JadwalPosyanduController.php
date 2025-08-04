<?php

namespace App\Http\Controllers;

use App\Models\JadwalPosyandu;
use App\Models\Posyandu; // Penting untuk dropdown
use Illuminate\Http\Request;

class JadwalPosyanduController extends Controller
{
    public function index()
    {
        // Ambil semua jadwal beserta data posyandu, dusun, dan desanya
        $jadwals = JadwalPosyandu::with('posyandu.dusun.desa')->latest()->get();
        return view('jadwal-posyandu.index', compact('jadwals'));
    }

    public function create()
    {
        // Ambil semua posyandu untuk ditampilkan di dropdown
        $posyandus = Posyandu::with('dusun.desa')->get();
        return view('jadwal-posyandu.create', compact('posyandus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandus,id',
            'jenis_kegiatan' => 'required|string|max:255', // <-- Validasi baru
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after_or_equal:waktu_mulai',
            'nama_kegiatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        JadwalPosyandu::create($request->all());

        return redirect()->route('jadwal-posyandu.index')
                         ->with('success', 'Jadwal baru berhasil ditambahkan.');
    }

    public function edit(JadwalPosyandu $jadwalPosyandu)
    {
        $posyandus = Posyandu::with('dusun.desa')->get();
        return view('jadwal-posyandu.edit', compact('jadwalPosyandu', 'posyandus'));
    }

    public function update(Request $request, JadwalPosyandu $jadwalPosyandu)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandus,id',
            'jenis_kegiatan' => 'required|string|max:255', // <-- Validasi baru
            'tanggal_kegiatan' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after_or_equal:waktu_mulai',
            'nama_kegiatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $jadwalPosyandu->update($request->all());

        return redirect()->route('jadwal-posyandu.index')
                         ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalPosyandu $jadwalPosyandu)
    {
        $jadwalPosyandu->delete();
        return redirect()->route('jadwal-posyandu.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }
}
