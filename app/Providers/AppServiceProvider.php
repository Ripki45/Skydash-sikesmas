<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // <-- Penting untuk migrasi
use App\Models\Kluster;
use App\Models\RunningText;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Set default string length untuk migrasi
        Schema::defaultStringLength(191);

        // REVISI UTAMA: Bagikan data ini ke SEMUA view secara global
        // Ini lebih kuat daripada View::composer
        try {
            $settings = Setting::pluck('value', 'key')->all();
            $klusters = Kluster::whereNull('parent_id')
                                ->with('childrenRecursive')
                                ->orderBy('order')
                                ->get();
            $runningText = RunningText::where('is_active', true)->first();

            View::share('settings', $settings);
            View::share('klusters', $klusters);
            View::share('runningText', $runningText);
        } catch (\Exception $e) {
            // Ini untuk mencegah error saat menjalankan migrate pertama kali
            // di mana tabel settings belum ada.
        }
    }
}
