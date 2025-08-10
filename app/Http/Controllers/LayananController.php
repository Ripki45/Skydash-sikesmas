<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Termwind\Components\Li;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data layanan, urutkan berdasarkan kolom 'urutan'
        $layanans = Layanan::orderBy('urutan')->get();

        // Kirim data ke view 'layanan.index'
        return view('layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_layanan' => 'required|string|max:255',
            'link' => 'required|url',
            'urutan' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $gambarPath = $request->file('gambar_icon')->store('layanan_icons', 'public');

        Layanan::create([
            'gambar_icon' => $gambarPath,
            'nama_layanan' => $request->nama_layanan,
            'link' => $request->link,
            'urutan' => $request->urutan,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.layanan.index')
                         ->with('success', 'Layanan baru berhasil ditambahkan.');
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
    public function edit(Layanan $layanan)
{
    return view('layanan.edit', compact('layanan'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'gambar_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_layanan' => 'required|string|max:255',
            'link' => 'required|url',
            'urutan' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $layananData = $request->except('gambar_icon');

        if ($request->hasFile('gambar_icon')) {
            Storage::disk('public')->delete($layanan->gambar_icon);
            $layananData['gambar_icon'] = $request->file('gambar_icon')->store('layanan_icons', 'public');
        }

        $layanan->update($layananData);

        return redirect()->route('admin.layanan.index')
                        ->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        // 1. Hapus file gambar/icon dari folder storage
        if ($layanan->gambar_icon) {
            Storage::disk('public')->delete($layanan->gambar_icon);
        }

        // 2. Hapus data layanan dari database
        $layanan->delete();

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.layanan.index')
                        ->with('success', 'Layanan berhasil dihapus.');
    }
}
