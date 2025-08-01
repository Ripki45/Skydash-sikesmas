<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Role;
use App\Models\User;
use App\Models\Dusun;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // 'with()' akan mengambil semua data relasi dalam satu query, sangat efisien!
        $users = User::with('roles', 'desa', 'dusun', 'posyandu.dusun.desa')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $desas = Desa::all();
        return view('users.create', compact('roles', 'desas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'desa_id' => ['nullable', 'exists:desas,id'],
            'dusun_id' => ['nullable', 'exists:dusuns,id'],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'], // <-- Validasi baru
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'desa_id' => $request->desa_id,
            'dusun_id' => $request->dusun_id,
            'posyandu_id' => $request->posyandu_id, // <-- Simpan posyandu_id
        ]);

        $user->roles()->attach($request->role_id);

        return redirect()->route('users.index')
                            ->with('success', 'Pengguna baru berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $desas = Desa::all();
        // Ambil dusun yang satu desa dengan user, untuk mengisi dropdown dusun
        $dusuns = $user->desa_id ? Dusun::where('desa_id', $user->desa_id)->get() : collect();
        // Ambil posyandu yang satu dusun dengan user, untuk mengisi dropdown posyandu
        $posyandus = $user->dusun_id ? Posyandu::where('dusun_id', $user->dusun_id)->get() : collect();


        return view('users.edit', compact('user', 'roles', 'desas', 'dusuns', 'posyandus'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'desa_id' => ['nullable', 'exists:desas,id'],
            'dusun_id' => ['nullable', 'exists:dusuns,id'],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'],
        ]);

        $userData = $request->except(['password', 'role_id', 'password_confirmation']);

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);
        $user->roles()->sync($request->role_id); // 'sync' akan memperbarui role

        return redirect()->route('users.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                        ->with('success', 'Akun berhasil dihapus.');
    }

    // Fungsi API untuk mengambil dusun berdasarkan desa
    public function getDusunsByDesa(Desa $desa)
    {
        return response()->json($desa->dusuns);
    }

    // Fungsi API baru untuk mengambil posyandu berdasarkan dusun
    public function getPosyandusByDusun(Dusun $dusun)
    {
        return response()->json($dusun->posyandus);
    }
}
