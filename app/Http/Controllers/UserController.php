<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Dusun;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'desa', 'dusun', 'posyandu'])->latest()->get();
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_name' => ['required', 'exists:roles,name'],
            'desa_id' => ['nullable', 'exists:desas,id'],
            'dusun_id' => ['nullable', 'exists:dusuns,id'],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'desa_id' => $request->desa_id,
            'dusun_id' => $request->dusun_id,
            'posyandu_id' => $request->posyandu_id,
        ]);

        $user->assignRole($request->role_name);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $desas = Desa::all();
        // Logika ini sudah bagus, kita ambil data dusun dan posyandu
        // yang relevan dengan data user saat ini.
        $dusuns = $user->desa_id ? Dusun::where('desa_id', $user->desa_id)->get() : collect();
        $posyandus = $user->dusun_id ? Posyandu::where('dusun_id', $user->dusun_id)->get() : collect();

        return view('users.edit', compact('user', 'roles', 'desas', 'dusuns', 'posyandus'));
    }

    public function update(Request $request, User $user)
    {
        // 1. Validasi disamakan dengan 'store', menggunakan 'role_name'
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Pastikan email unik, kecuali untuk user ini sendiri
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            // Password sekarang boleh kosong (nullable)
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_name' => ['required', 'exists:roles,name'],
            'desa_id' => ['nullable', 'exists:desas,id'],
            'dusun_id' => ['nullable', 'exists:dusuns,id'],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'],
        ]);

        // 2. Update data dasar pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'desa_id' => $request->desa_id,
            'dusun_id' => $request->dusun_id,
            'posyandu_id' => $request->posyandu_id,
        ]);

        // 3. Hanya update password jika kolomnya diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // 4. Gunakan 'syncRoles' dari Spatie untuk memperbarui peran.
        // Ini lebih aman daripada sync() biasa.
        $user->syncRoles($request->role_name);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }

    // PERBAIKAN #3: Fungsi API disesuaikan untuk menerima POST request
    public function getDusunsByDesa(Request $request)
    {
        $request->validate(['desa_id' => 'required|exists:desas,id']);
        $dusuns = Dusun::where('desa_id', $request->desa_id)->get();
        return response()->json($dusuns);
    }

    public function getPosyandusByDusun(Request $request)
    {
        $request->validate(['dusun_id' => 'required|exists:dusuns,id']);
        $posyandus = Posyandu::where('dusun_id', $request->dusun_id)->get();
        return response()->json($posyandus);
    }
}
