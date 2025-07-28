<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\Kluster;
use Illuminate\Http\Request;

class KlusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil HANYA menu induk (yang parent_id nya null)
        // 'with('children')' akan otomatis mengambil semua sub-menunya secara efisien
        $klusters = Kluster::whereNull('parent_id')->with('children')->orderBy('order')->get();

        return view('kluster.index', compact('klusters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // <--- UBAH FUNGSI INI
    {
        $halamans = Halaman::where('status', 'published')->pluck('judul', 'id');
        $klusters = Kluster::pluck('title', 'id');
        return view('kluster.create', compact('halamans', 'klusters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // <--- UBAH FUNGSI INI
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:klusters,id',
            'halaman_id' => 'nullable|exists:halamans,id',
            'url' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        Kluster::create($request->all());

        return redirect()->route('kluster.index')
                         ->with('success', 'Menu baru berhasil ditambahkan.');
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
    public function edit(Kluster $kluster)
    {
        $halamans = Halaman::where('status', 'published')->pluck('judul', 'id');
        $klusters = Kluster::where('id', '!=', $kluster->id)->pluck('title', 'id'); // Menu lain selain diri sendiri
        return view('kluster.edit', compact('kluster', 'halamans', 'klusters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kluster $kluster)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:klusters,id',
            'halaman_id' => 'nullable|exists:halamans,id',
            'url' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        $kluster->update($request->all());

        return redirect()->route('kluster.index')
                        ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kluster $kluster)
    {
        $kluster->delete();

        return redirect()->route('kluster.index')
                        ->with('success', 'Menu berhasil dihapus.');
    }
}
