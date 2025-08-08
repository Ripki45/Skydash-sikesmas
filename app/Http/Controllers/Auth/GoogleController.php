<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman otentikasi Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Mendapatkan informasi pengguna dari Google dan menanganinya.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // 1. Cari user di database berdasarkan alamat email dari Google
            $user = \App\Models\User::where('email', $googleUser->getEmail())->first();

            // 2. JIKA USER DITEMUKAN
            if ($user) {
                // Update google_id dan avatar jika belum ada (opsional, tapi bagus)
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);

                // Login-kan user tersebut
                Auth::login($user);

                // Arahkan ke halaman dashboard
                return redirect('/dashboard');
            }

            // 3. JIKA USER TIDAK DITEMUKAN
            // Kembalikan ke halaman login dengan sebuah pesan error
            return redirect('/login')->with('error', 'Akun kamu belum terdaftar. Silakan lakukan registrasi terlebih dahulu.');

        } catch (\Exception $e) {
            // Tangani jika ada error lain dari Google
            return redirect('/login')->with('error', 'Terjadi masalah saat proses otentikasi dengan Google.');
        }
    }
}
