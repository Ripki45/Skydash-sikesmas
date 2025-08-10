<?php

namespace App\Http\Controllers\Auth;

use App\Models\Desa;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Ambil semua data desa dari database
        $desas = Desa::all();

        // Kirim data desa tersebut ke view
        return view('auth.register', compact('desas'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'desa_id' => ['required', 'exists:desas,id'],     // Validasi untuk desa
            'dusun_id' => ['required', 'exists:dusuns,id'],   // Validasi untuk dusun
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'desa_id' => $request->desa_id,                 // Simpan ID desa
            'dusun_id' => $request->dusun_id,               // Simpan ID dusun
        ]);

        $user->assignRole('Masyarakat');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
