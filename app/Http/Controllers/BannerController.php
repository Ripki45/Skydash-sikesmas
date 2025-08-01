<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\RunningText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua banner, urutkan berdasarkan 'urutan_tampil'
        $banners = Banner::orderBy('urutan_tampil')->get();

        // Ambil data running text. Jika tidak ada, buat satu yang kosong.
        $runningText = RunningText::firstOrCreate(
            ['id' => 1],
            ['teks' => 'Selamat datang di website kami.', 'is_active' => true]
        );

        // Kirim kedua data ke view
        return view('banner.index', compact('banners', 'runningText'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Hanya menampilkan halaman form
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'gambar_banner' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'urutan_tampil' => 'required|integer',
        ]);

        // Proses upload gambar
        $gambarPath = $request->file('gambar_banner')->store('banner_images', 'public');

        // Simpan ke database
        Banner::create([
            'gambar_banner' => $gambarPath,
            'urutan_tampil' => $request->urutan_tampil,
        ]);

        return redirect()->route('banner.index')
                         ->with('success', 'Banner baru berhasil ditambahkan.');
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
    public function edit(Banner $banner)
    {
        return view('banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'gambar_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'urutan_tampil' => 'required|integer',
        ]);

        $bannerData = $request->except('gambar_banner');

        if ($request->hasFile('gambar_banner')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($banner->gambar_banner);
            // Simpan gambar baru
            $bannerData['gambar_banner'] = $request->file('gambar_banner')->store('banner_images', 'public');
        }

        $banner->update($bannerData);

        return redirect()->route('banner.index')
                        ->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Hapus gambar dari storage
        Storage::disk('public')->delete($banner->gambar_banner);
        // Hapus data dari database
        $banner->delete();

        return redirect()->route('banner.index')
                        ->with('success', 'Banner berhasil dihapus.');
    }

    public function updateRunningText(Request $request)
    {
        $request->validate([
            'teks' => 'required|string',
            'link' => 'nullable|url',
            'is_active' => 'required|boolean',
        ]);

        $runningText = RunningText::find(1);
        $runningText->update($request->all());

        return redirect()->route('banner.index')
                        ->with('success', 'Running text berhasil diperbarui.');
    }

}
