<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua pengumuman, urutkan dari yang paling baru dibuat
        $pengumumans = Pengumuman::latest()->get();

        // Kirim data ke view 'pengumuman.index'
        return view('pengumuman.index', compact('pengumumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengumuman.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120', // Max 5MB
            'tipe' => 'required|in:info,popup,banner',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:published,draft',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('pengumuman_files', 'public');
        }

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'lampiran' => $lampiranPath,
            'tipe' => $request->tipe,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', compact('pengumuman'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->all();
        $pengumuman->update($data);
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'tipe' => 'required|in:info,popup,banner',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:published,draft',
        ]);

        $pengumumanData = $request->except('lampiran');

        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($pengumuman->lampiran) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            // Simpan lampiran baru
            $pengumumanData['lampiran'] = $request->file('lampiran')->store('pengumuman_files', 'public');
        }

        $pengumuman->update($pengumumanData);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman) // <-- ISI FUNGSI INI
    {
        // Hapus gambar unggulan dari storage jika ada
        if ($pengumuman->pengumuman_files) {
            Storage::disk('public')->delete($pengumuman->pengumuman_files);
        }

        // Hapus data dari database
        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
