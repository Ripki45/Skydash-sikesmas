<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */ // <-- INILAH "CONTEKAN" UNTUK EDITOR
        $user = Auth::user();

        // Sekarang editor tahu bahwa $user adalah objek dari App\Models\User
        // yang memiliki semua kekuatan dari trait HasRoles.
        // Garis merahnya pasti akan hilang.
        if ($user->hasRole('Masyarakat')) {
            return redirect()->route('masyarakat.dashboard');
        }

        $totalUsers = User::count();
        $totalBerita = Berita::count();
        $roles = Role::withCount('users')->get();
        $latestUsers = User::with('roles')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalBerita',
            'roles',
            'latestUsers'
        ));
    }
}
