<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\Kluster;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HalamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua halaman, diurutkan dari yang paling baru
        $halamans = Halaman::latest()->get();

        // Mengirim data ke view 'halaman.index'
        return view('halaman.index', compact('halamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // <-- ISI FUNGSI INI
    {
        // Ambil data kluster/menu induk untuk dropdown
        $klusters = Kluster::whereNull('parent_id')->get();
        return view('halaman.create', compact('klusters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // <-- ISI FUNGSI INI
    {
        // 1. Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar_unggulan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
            'kluster_id' => 'nullable|exists:klusters,id',
        ]);

        // 2. Proses upload gambar jika ada
        $gambarPath = null;
        if ($request->hasFile('gambar_unggulan')) {
            $gambarPath = $request->file('gambar_unggulan')->store('halaman_images', 'public');
        }

        // 3. Simpan data ke database
        Halaman::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul, '-'), // Membuat slug otomatis
            'konten' => $request->konten,
            'gambar_unggulan' => $gambarPath,
            'status' => $request->status,
            'kluster_id' => $request->kluster_id,
        ]);

        // 4. Redirect ke halaman index dengan pesan sukses
        return redirect()->route('halaman.index')
                         ->with('success', 'Halaman baru berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Halaman $halaman)
    {
        return view('halaman.show', compact('halaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Halaman $halaman) // <-- ISI FUNGSI INI
    {
        $klusters = Kluster::whereNull('parent_id')->get();
        return view('halaman.edit', compact('halaman', 'klusters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Halaman $halaman) // <-- ISI FUNGSI INI
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar_unggulan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
            'kluster_id' => 'nullable|exists:klusters,id',
        ]);

        $halamanData = $request->except('gambar_unggulan');
        $halamanData['slug'] = Str::slug($request->judul, '-');

        if ($request->hasFile('gambar_unggulan')) {
            // Hapus gambar lama
            if ($halaman->gambar_unggulan) {
                Storage::disk('public')->delete($halaman->gambar_unggulan);
            }
            // Simpan gambar baru
            $halamanData['gambar_unggulan'] = $request->file('gambar_unggulan')->store('halaman_images', 'public');
        }

        $halaman->update($halamanData);

        return redirect()->route('halaman.index')
                         ->with('success', 'Halaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Halaman $halaman) // <-- ISI FUNGSI INI
    {
        // Hapus gambar unggulan dari storage jika ada
        if ($halaman->gambar_unggulan) {
            Storage::disk('public')->delete($halaman->gambar_unggulan);
        }

        // Hapus data dari database
        $halaman->delete();

        return redirect()->route('halaman.index')
                         ->with('success', 'Halaman berhasil dihapus.');
    }
}
