<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- TAMBAHKAN INI
use App\Models\Kluster;              // <-- TAMBAHKAN INI

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // REVISI: Bagikan data menu ke view header frontend
        View::composer('layouts.partials.frontend.header', function ($view) {
            $klusters = Kluster::whereNull('parent_id')
                                ->with('children') // Ambil juga semua sub-menunya
                                ->orderBy('order')
                                ->get();
            $view->with('klusters', $klusters);
        });
    }
}
