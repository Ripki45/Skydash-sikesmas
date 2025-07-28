<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data galeri, urutkan berdasarkan 'urutan'
        $galeris = Galeri::orderBy('urutan')->get();

        // Kirim data ke view 'galeri.index'
        return view('galeri.index', compact('galeris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'path_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
        ]);

        $gambarPath = $request->file('path_gambar')->store('galeri_images', 'public');

        Galeri::create([
            'path_gambar' => $gambarPath,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'kategori' => $request->kategori,
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('galeri.index')
                         ->with('success', 'Foto baru berhasil ditambahkan.');
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
    public function edit(Galeri $galeri)
    {
        // Menampilkan form edit dengan data foto yang dipilih
        return view('galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
        ]);

        $galeriData = $request->except('path_gambar');

        if ($request->hasFile('path_gambar')) {
            // Hapus gambar lama jika ada
            if ($galeri->path_gambar) {
                Storage::disk('public')->delete($galeri->path_gambar);
            }
            // Upload dan simpan path gambar baru
            $galeriData['path_gambar'] = $request->file('path_gambar')->store('galeri_images', 'public');
        }

        // Update data di database
        $galeri->update($galeriData);

        return redirect()->route('galeri.index')
                         ->with('success', 'Data foto berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        // Hapus file gambar dari storage
        if ($galeri->path_gambar) {
            Storage::disk('public')->delete($galeri->path_gambar);
        }

        // Hapus data dari database
        $galeri->delete();

        return redirect()->route('galeri.index')
                        ->with('success', 'Foto berhasil dihapus.');
    }
}
