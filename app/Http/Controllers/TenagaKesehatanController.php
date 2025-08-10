<?php

namespace App\Http\Controllers;

use App\Models\TenagaKesehatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenagaKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenagaKesehatans = TenagaKesehatan::latest()->get();
        return view('tenaga-kesehatan.index', compact('tenagaKesehatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenaga-kesehatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip_nik' => 'nullable|string|max:255|unique:tenaga_kesehatans,nip_nik',
            'jabatan' => 'required|string|max:255',
            'spesialisasi' => 'nullable|string|max:255',
            'jadwal_praktik' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('sdm_photos', 'public');
        }

        TenagaKesehatan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nip_nik' => $request->nip_nik,
            'jabatan' => $request->jabatan,
            'spesialisasi' => $request->spesialisasi,
            'jadwal_praktik' => $request->jadwal_praktik,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.tenaga-kesehatan.index')
                         ->with('success', 'Data tenaga kesehatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenagaKesehatan $tenagaKesehatan)
    {
        return view('tenaga-kesehatan.edit', compact('tenagaKesehatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenagaKesehatan $tenagaKesehatan)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip_nik' => 'nullable|string|max:255|unique:tenaga_kesehatans,nip_nik,' . $tenagaKesehatan->id,
            'jabatan' => 'required|string|max:255',
            'spesialisasi' => 'nullable|string|max:255',
            'jadwal_praktik' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($tenagaKesehatan->foto) {
                Storage::disk('public')->delete($tenagaKesehatan->foto);
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('sdm_photos', 'public');
        }

        $tenagaKesehatan->update($data);

        return redirect()->route('admin.tenaga-kesehatan.index')
                         ->with('success', 'Data tenaga kesehatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKesehatan $tenagaKesehatan)
    {
        // Hapus foto dari storage jika ada
        if ($tenagaKesehatan->foto) {
            Storage::disk('public')->delete($tenagaKesehatan->foto);
        }

        $tenagaKesehatan->delete();

        return redirect()->route('admin.tenaga-kesehatan.index')
                         ->with('success', 'Data tenaga kesehatan berhasil dihapus.');
    }
}
