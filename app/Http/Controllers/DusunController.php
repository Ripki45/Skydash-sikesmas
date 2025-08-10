<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Desa;
use Illuminate\Http\Request;

class DusunController extends Controller
{
    public function index()
    {
        // Ambil semua dusun beserta data desanya menggunakan 'with()'
        $dusuns = Dusun::with('desa')->latest()->get();
        return view('dusun.index', compact('dusuns'));
    }

    public function create()
    {
        // Ambil semua desa untuk ditampilkan di dropdown
        $desas = Desa::all();
        return view('dusun.create', compact('desas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'desa_id' => 'required|exists:desas,id',
            'nama_dusun' => 'required|string|max:255',
        ]);

        Dusun::create($request->all());

        return redirect()->route('admin.dusun.index')
                         ->with('success', 'Dusun baru berhasil ditambahkan.');
    }

    public function edit(Dusun $dusun)
    {
        $desas = Desa::all();
        return view('dusun.edit', compact('dusun', 'desas'));
    }

    public function update(Request $request, Dusun $dusun)
    {
        $request->validate([
            'desa_id' => 'required|exists:desas,id',
            'nama_dusun' => 'required|string|max:255',
        ]);

        $dusun->update($request->all());

        return redirect()->route('admin.dusun.index')
                         ->with('success', 'Data dusun berhasil diperbarui.');
    }

    public function destroy(Dusun $dusun)
    {
        $dusun->delete();
        return redirect()->route('admin.dusun.index')
                         ->with('success', 'Data dusun berhasil dihapus.');
    }
}
