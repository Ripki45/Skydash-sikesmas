<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\Kluster; // <-- Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HalamanController extends Controller
{
    public function index()
    {
        $halamans = Halaman::latest()->get();
        return view('halaman.index', compact('halamans'));
    }

    /**
     * REVISI UTAMA: Fungsi create() yang sudah mengambil data Kluster
     */
    public function create()
    {
        // Ambil data kluster/menu induk untuk dropdown
        $klusters = Kluster::whereNull('parent_id')->get();
        return view('halaman.create', compact('klusters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar_unggulan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
            'kluster_id' => 'nullable|exists:klusters,id',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_unggulan')) {
            $gambarPath = $request->file('gambar_unggulan')->store('halaman_images', 'public');
        }

        $halamanBaru = Halaman::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul, '-'),
            'konten' => $request->konten,
            'gambar_unggulan' => $gambarPath,
            'status' => $request->status,
            'kluster_id' => $request->kluster_id,
        ]);

        return redirect()->route('halaman.index')
                        ->with('success', 'Halaman baru berhasil dibuat.');
    }

    public function show(Halaman $halaman)
    {
        return view('halaman.show', compact('halaman'));
    }

    public function edit(Halaman $halaman)
    {
        $klusters = Kluster::whereNull('parent_id')->get();
        return view('halaman.edit', compact('halaman', 'klusters'));
    }

    public function update(Request $request, Halaman $halaman)
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
            if ($halaman->gambar_unggulan) {
                Storage::disk('public')->delete($halaman->gambar_unggulan);
            }
            $halamanData['gambar_unggulan'] = $request->file('gambar_unggulan')->store('halaman_images', 'public');
        }

        $halaman->update($halamanData);

        return redirect()->route('halaman.index')
                         ->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Halaman $halaman)
    {
        if ($halaman->gambar_unggulan) {
            Storage::disk('public')->delete($halaman->gambar_unggulan);
        }
        $halaman->delete();
        return redirect()->route('halaman.index')
                         ->with('success', 'Halaman berhasil dihapus.');
    }
}
