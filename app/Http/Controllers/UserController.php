<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getDusunsByDesa(Desa $desa)
    {
        // Ambil semua dusun yang dimiliki oleh desa yang dipilih
        return response()->json($desa->dusuns);
    }

    public function index()
    {
        // Ambil semua user, dan muat relasi 'roles' mereka secara efisien
        $users = User::with('roles')->latest()->get();

        // Kirim data ke view
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data Roles dan Desa
        $roles = Role::all();
        $desas = Desa::all();

        // Kirim data ke view
        return view('users.create', compact('roles', 'desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'desa_id' => ['nullable', 'exists:desas,id'],
            'dusun_id' => ['nullable', 'exists:dusuns,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'desa_id' => $request->desa_id,
            'dusun_id' => $request->dusun_id,
        ]);

        // Menghubungkan user dengan peran yang dipilih
        $user->roles()->attach($request->role_id);

        return redirect()->route('users.index')
                        ->with('success', 'Pengguna baru berhasil dibuat.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
