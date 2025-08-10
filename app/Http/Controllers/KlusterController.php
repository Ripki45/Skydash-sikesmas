<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use App\Models\Kluster;
use Illuminate\Http\Request;

class KlusterController extends Controller
{
    public function index()
    {
        $klusters = Kluster::whereNull('parent_id')->with('children')->orderBy('order')->get();
        return view('kluster.index', compact('klusters'));
    }

    public function create()
    {
        $halamans = Halaman::where('status', 'published')->pluck('judul', 'id');
        $klusters = Kluster::pluck('title', 'id');
        return view('kluster.create', compact('halamans', 'klusters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:klusters,id',
            'halaman_id' => 'nullable|exists:halamans,id',
            'url' => 'nullable|string|max:255',
            'order' => 'required|integer',
        ]);

        Kluster::create($request->all());

        // PERBAIKAN #1: Arahkan ke rute admin yang baru
        return redirect()->route('admin.kluster.index')
                         ->with('success', 'Menu baru berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        // Biasanya tidak digunakan untuk manajemen admin
    }

    public function edit(Kluster $kluster)
    {
        $halamans = Halaman::where('status', 'published')->pluck('judul', 'id');
        $klusters = Kluster::where('id', '!=', $kluster->id)->pluck('title', 'id');
        return view('kluster.edit', compact('kluster', 'halamans', 'klusters'));
    }

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

        // PERBAIKAN #2: Arahkan ke rute admin yang baru
        return redirect()->route('admin.kluster.index')
                         ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Kluster $kluster)
    {
        $kluster->delete();

        // PERBAIKAN #3: Arahkan ke rute admin yang baru
        return redirect()->route('admin.kluster.index')
                         ->with('success', 'Menu berhasil dihapus.');
    }
}
