<?php

namespace App\Http\Controllers;

use App\Models\Pustu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PustuController extends Controller
{
    public function index()
    {
        $pustus = Pustu::latest()->get();
        return view('pustu.index', compact('pustus'));
    }

    public function create()
    {
        return view('pustu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pustu' => 'required|string|max:255',
            'photo_pustu' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tenaga_kesehatan' => 'nullable|string',
            'alamat' => 'required|string',
            'jadwal_layanan' => 'nullable|string|max:255',
            'lokasi_map' => 'nullable|url',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_pustu')) {
            $photoPath = $request->file('photo_pustu')->store('pustu_photos', 'public');
        }

        Pustu::create([
            'nama_pustu' => $request->nama_pustu,
            'photo_pustu' => $photoPath,
            'tenaga_kesehatan' => $request->tenaga_kesehatan,
            'alamat' => $request->alamat,
            'jadwal_layanan' => $request->jadwal_layanan,
            'lokasi_map' => $request->lokasi_map,
        ]);

        return redirect()->route('admin.pustu.index')
                         ->with('success', 'Data Pustu baru berhasil ditambahkan.');
    }

    public function edit(Pustu $pustu)
    {
        return view('pustu.edit', compact('pustu'));
    }

    public function update(Request $request, Pustu $pustu)
    {
        $request->validate([
            'nama_pustu' => 'required|string|max:255',
            'photo_pustu' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tenaga_kesehatan' => 'nullable|string',
            'alamat' => 'required|string',
            'jadwal_layanan' => 'nullable|string|max:255',
            'lokasi_map' => 'nullable|url',
        ]);

        $pustuData = $request->except('photo_pustu');

        if ($request->hasFile('photo_pustu')) {
            if ($pustu->photo_pustu) {
                Storage::disk('public')->delete($pustu->photo_pustu);
            }
            $pustuData['photo_pustu'] = $request->file('photo_pustu')->store('pustu_photos', 'public');
        }

        $pustu->update($pustuData);

        return redirect()->route('admin.pustu.index')
                         ->with('success', 'Data Pustu berhasil diperbarui.');
    }

    public function destroy(Pustu $pustu)
    {
        // REVISI PENTING: Menggunakan nama kolom yang benar
        if ($pustu->photo_pustu) {
            Storage::disk('public')->delete($pustu->photo_pustu);
        }

        $pustu->delete();

        return redirect()->route('admin.pustu.index')
                         ->with('success', 'Data Pustu berhasil dihapus.');
    }
}
