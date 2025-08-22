<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengumumanController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pengumuman.
     */
    public function index()
    {
        $pengumumans = Pengumuman::latest()->paginate(10);
        return view('pengumuman.index', compact('pengumumans'));
    }

    /**
     * Menampilkan form untuk membuat pengumuman baru.
     */
    public function create()
    {
        return view('pengumuman.create');
    }

    /**
     * Menyimpan pengumuman baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => [Rule::requiredIf($request->tipe === 'info'), 'nullable', 'string'],
            // PERBAIKAN #1: Lampiran sekarang SELALU divalidasi sebagai file jika ada
            'lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
            'tipe' => 'required|in:info,popup,banner',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:published,draft',
        ]);

        if ($request->hasFile('lampiran')) {
            $validatedData['lampiran'] = $request->file('lampiran')->store('pengumuman_files', 'public');
        }

        Pengumuman::create($validatedData);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit pengumuman.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Memperbarui data pengumuman di database.
     */
    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => [Rule::requiredIf($request->tipe === 'info'), 'nullable', 'string'],
            // PERBAIKAN #2: Terapkan juga di method update
            'lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
            'tipe' => 'required|in:info,popup,banner',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:published,draft',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($pengumuman->lampiran) {
                Storage::disk('public')->delete($pengumuman->lampiran);
            }
            $validatedData['lampiran'] = $request->file('lampiran')->store('pengumuman_files', 'public');
        }

        $pengumuman->update($validatedData);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui.');
    }


    /**
     * Menghapus data pengumuman dari database.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        if ($pengumuman->lampiran) {
            Storage::disk('public')->delete($pengumuman->lampiran);
        }
        $pengumuman->delete();
        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
