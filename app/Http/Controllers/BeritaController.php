<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::with('kategori', 'user', 'tags')->latest()->get();
        $kategoris = Kategori::all();
        return view('berita.index', compact('beritas', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $tags = Tag::all();
        return view('berita.create', compact('kategoris', 'tags'));
    }

    /**
     * REVISI TOTAL: Fungsi store() yang sudah lengkap
     */
   public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'isi_berita' => 'required|string',
            'gambar_unggulan' => 'required|image|mimes:jpeg,png,jpg,gif|max:6048',
            'status' => 'required|in:published,draft',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
        ]);

        // 2. Proses upload gambar
        $gambarPath = $request->file('gambar_unggulan')->store('berita_images', 'public');

        // 3. Simpan data berita ke database
        $berita = Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul, '-'),
            'user_id' => Auth::id(), // <-- INI DIA KUNCINYA! Mengambil ID user yang login
            'kategori_id' => $request->kategori_id,
            'isi_berita' => $request->isi_berita,
            'gambar_unggulan' => $gambarPath,
            'status' => $request->status,
            'published_at' => $request->published_at ?? now(),
        ]);

        // 4. Hubungkan berita dengan tag yang dipilih
        if ($request->has('tags')) {
            $berita->tags()->attach($request->tags);
        }

        return redirect()->route('berita.index')
                        ->with('success', 'Berita baru berhasil dipublikasikan.');
    }

    public function show(Berita $berita)
    {
        // Jika Anda butuh halaman detail, bisa dibuat di sini
    }

    public function edit(Berita $berita)
    {
        $kategoris = Kategori::all();
        $tags = Tag::all();
        return view('berita.edit', compact('berita', 'kategoris', 'tags'));
    }

    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'isi_berita' => 'required|string',
            'gambar_unggulan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6048',
            'status' => 'required|in:published,draft',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
        ]);

        $beritaData = $request->except(['gambar_unggulan', 'tags']);
        $beritaData['slug'] = Str::slug($request->judul, '-');
        $beritaData['published_at'] = $request->published_at ?? now();

        if ($request->hasFile('gambar_unggulan')) {
            if ($berita->gambar_unggulan) {
                Storage::disk('public')->delete($berita->gambar_unggulan);
            }
            $beritaData['gambar_unggulan'] = $request->file('gambar_unggulan')->store('berita_images', 'public');
        }

        $berita->update($beritaData);

        if ($request->has('tags')) {
            $berita->tags()->sync($request->tags);
        } else {
            $berita->tags()->detach();
        }

        return redirect()->route('berita.index')
                         ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * REVISI: Fungsi destroy() yang sudah diisi
     */
    public function destroy(Berita $berita)
    {
        // Hapus gambar dari storage
        if ($berita->gambar_unggulan) {
            Storage::disk('public')->delete($berita->gambar_unggulan);
        }
        // Hapus data berita dari database
        $berita->delete();

        return redirect()->route('berita.index')
                         ->with('success', 'Berita berhasil dihapus.');
    }
}
