<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SinergiProgram;
use Illuminate\Support\Facades\Storage;

class SinergiProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data sinergi program, urutkan berdasarkan 'urutan'
        $sinergiPrograms = SinergiProgram::orderBy('urutan')->get();

        // Kirim data ke view 'sinergi-program.index'
        return view('sinergi-program.index', compact('sinergiPrograms'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sinergi-program.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar_icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_program' => 'required|string|max:255',
            'link' => 'required|url',
            'urutan' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $gambarPath = $request->file('gambar_icon')->store('sinergi_icons', 'public');

        SinergiProgram::create([
            'gambar_icon' => $gambarPath,
            'nama_program' => $request->nama_program,
            'link' => $request->link,
            'urutan' => $request->urutan,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('sinergi-program.index')
                         ->with('success', 'Program baru berhasil ditambahkan.');
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
    public function edit(SinergiProgram $sinergiProgram)
    {
        return view('sinergi-program.edit', compact('sinergiProgram'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SinergiProgram $sinergiProgram)
    {
        $request->validate([
            'gambar_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_program' => 'required|string|max:255',
            'link' => 'required|url',
            'urutan' => 'required|integer',
            'is_active' => 'required|boolean',
        ]);

        $programData = $request->except('gambar_icon');

        if ($request->hasFile('gambar_icon')) {
            Storage::disk('public')->delete($sinergiProgram->gambar_icon);
            $programData['gambar_icon'] = $request->file('gambar_icon')->store('sinergi_icons', 'public');
        }

        $sinergiProgram->update($programData);

        return redirect()->route('sinergi-program.index')
                        ->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SinergiProgram $program)
    {
        // 1. Hapus file gambar/icon dari folder storage
        if ($program->sinergi_icon) {
            Storage::disk('public')->delete($program->sinergi_icon);
        }

        // 2. Hapus data layanan dari database
        $program->delete();

        // 3. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('sinergi-program.index')
                        ->with('success', 'Layanan berhasil dihapus.');
    }
}
