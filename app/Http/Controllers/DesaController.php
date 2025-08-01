<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data desa, urutkan dari yang paling baru
        $desas = Desa::latest()->get();

        // Kirim data ke view 'desa.index'
        return view('desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('desa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_desa' => 'required|string|max:255|unique:desas',
        ]);

        Desa::create($request->all());

        return redirect()->route('desa.index')
                         ->with('success', 'Desa baru berhasil ditambahkan.');
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
    public function edit(Desa $desa)
    {
        return view('desa.edit', compact('desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desa $desa)
    {
        $request->validate([
            // 'unique' akan mengabaikan data desa yang sedang diedit
            'nama_desa' => 'required|string|max:255|unique:desas,nama_desa,' . $desa->id,
        ]);

        $desa->update($request->all());

        return redirect()->route('desa.index')
                         ->with('success', 'Data desa berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $desa)
    {
        $desa->delete();

        return redirect()->route('desa.index')
                        ->with('success', 'Desa berhasil dihapus.');
    }
}
