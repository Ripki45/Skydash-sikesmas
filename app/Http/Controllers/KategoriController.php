<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::latest()->get();
        // Kita kirim juga satu variabel kosong untuk form edit, nanti akan berguna
        $kategoriToEdit = null;
        return view('kategori.index', compact('kategoris', 'kategoriToEdit'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori, '-'), // Slug otomatis
        ]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori baru berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function edit(Kategori $kategori)
    {
        $kategoris = Kategori::latest()->get();
        // Mengirim data kategori yang akan di-edit ke view
        return view('kategori.index', ['kategoris' => $kategoris, 'kategoriToEdit' => $kategori]);
    }

    // FUNGSI BARU UNTUK MENYIMPAN PERUBAHAN
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori, '-'),
        ]);

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // REVISI: Cek dulu apakah kategori ini punya berita
        if ($kategori->beritas()->count() > 0) {
            // Jika ada, kembalikan dengan pesan error
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Kategori ini tidak dapat dihapus karena masih digunakan oleh berita.');
        }

        // Jika tidak ada berita yang terhubung, barulah hapus
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}
