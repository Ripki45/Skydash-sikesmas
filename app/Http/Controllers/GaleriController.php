<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\GaleriKategori; // <-- Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        // 'with('kategori')' akan mengambil relasi kategori secara efisien
        $galeris = Galeri::with('kategori')->orderBy('urutan')->get();
        return view('galeri.index', compact('galeris'));
    }

    public function create()
    {
        $kategoris = GaleriKategori::all();
        return view('galeri.create', compact('kategoris'));
    }

    /**
     * REVISI UTAMA: Fungsi store() yang sudah diperbarui
     */
    public function store(Request $request)
    {
        $request->validate([
            'path_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'galeri_kategori_id' => 'nullable|exists:galeri_kategoris,id', // <-- Validasi baru
            'urutan' => 'required|integer',
        ]);

        $gambarPath = $request->file('path_gambar')->store('galeri_images', 'public');

        Galeri::create([
            'path_gambar' => $gambarPath,
            'judul' => $request->judul,
            'keterangan' => $request->keterangan,
            'galeri_kategori_id' => $request->galeri_kategori_id, // <-- Simpan ID kategori
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('galeri.index')
                         ->with('success', 'Foto baru berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        $kategoris = GaleriKategori::all();
        return view('galeri.edit', compact('galeri', 'kategoris'));
    }

    /**
     * REVISI UTAMA: Fungsi update() yang sudah diperbarui
     */
    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'path_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'galeri_kategori_id' => 'nullable|exists:galeri_kategoris,id', // <-- Validasi baru
            'urutan' => 'required|integer',
        ]);

        $galeriData = $request->except('path_gambar');

        if ($request->hasFile('path_gambar')) {
            Storage::disk('public')->delete($galeri->path_gambar);
            $galeriData['path_gambar'] = $request->file('path_gambar')->store('galeri_images', 'public');
        }

        $galeri->update($galeriData);

        return redirect()->route('galeri.index')
                         ->with('success', 'Data foto berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->path_gambar) {
            Storage::disk('public')->delete($galeri->path_gambar);
        }
        $galeri->delete();
        return redirect()->route('galeri.index')
                         ->with('success', 'Foto berhasil dihapus.');
    }
}
