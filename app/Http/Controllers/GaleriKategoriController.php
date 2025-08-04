<?php

namespace App\Http\Controllers;

use App\Models\GaleriKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GaleriKategoriController extends Controller
{
    public function index()
    {
        $kategoris = GaleriKategori::latest()->get();
        // Kirim variabel 'kategoriToEdit' sebagai null secara default
        return view('galeri-kategori.index', ['kategoris' => $kategoris, 'kategoriToEdit' => null]);
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:galeri_kategoris,nama_kategori']);
        GaleriKategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ]);
        return redirect()->route('galeri-kategori.index')->with('success', 'Kategori galeri baru berhasil ditambahkan.');
    }

    // FUNGSI INI AKAN MENGIRIM DATA KE FORM EDIT
    public function edit(GaleriKategori $galeriKategori)
    {
        $kategoris = GaleriKategori::latest()->get();
        // Kirim data kategori yang akan diedit ke view yang sama (index)
        return view('galeri-kategori.index', [
            'kategoris' => $kategoris,
            'kategoriToEdit' => $galeriKategori,
        ]);
    }

    // FUNGSI INI AKAN MENYIMPAN PERUBAHAN
    public function update(Request $request, GaleriKategori $galeriKategori)
    {
        $request->validate(['nama_kategori' => 'required|string|max:255|unique:galeri_kategoris,nama_kategori,' . $galeriKategori->id]);
        $galeriKategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ]);
        return redirect()->route('galeri-kategori.index')->with('success', 'Kategori galeri berhasil diperbarui.');
    }

    // FUNGSI HAPUS
    public function destroy(GaleriKategori $galeriKategori)
    {
        if ($galeriKategori->galeris()->count() > 0) {
            return redirect()->route('galeri-kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh foto di galeri.');
        }
        $galeriKategori->delete();
        return redirect()->route('galeri-kategori.index')->with('success', 'Kategori galeri berhasil dihapus.');
    }
}
