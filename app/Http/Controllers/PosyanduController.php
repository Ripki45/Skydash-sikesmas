<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\Dusun; // Penting untuk dropdown
use Illuminate\Http\Request;

class PosyanduController extends Controller
{
    public function index()
    {
        // Ambil semua posyandu beserta data dusun dan desanya
        $posyandus = Posyandu::with('dusun.desa')->latest()->get();
        return view('posyandu.index', compact('posyandus'));
    }

    public function create()
    {
        // Ambil semua dusun untuk ditampilkan di dropdown
        $dusuns = Dusun::with('desa')->get();
        return view('posyandu.create', compact('dusuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nama_posyandu' => 'required|string|max:255',
        ]);

        Posyandu::create($request->all());

        return redirect()->route('admin.posyandu.index')
                         ->with('success', 'Posyandu baru berhasil ditambahkan.');
    }

    public function edit(Posyandu $posyandu)
    {
        $dusuns = Dusun::with('desa')->get();
        return view('posyandu.edit', compact('posyandu', 'dusuns'));
    }

    public function update(Request $request, Posyandu $posyandu)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nama_posyandu' => 'required|string|max:255',
        ]);

        $posyandu->update($request->all());

        return redirect()->route('admin.posyandu.index')
                         ->with('success', 'Data posyandu berhasil diperbarui.');
    }

    public function destroy(Posyandu $posyandu)
    {
        $posyandu->delete();
        return redirect()->route('admin.posyandu.index')
                         ->with('success', 'Data posyandu berhasil dihapus.');
    }
}
