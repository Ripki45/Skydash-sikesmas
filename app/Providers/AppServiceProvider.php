<?php

namespace App\Providers;

use App\Models\RunningText;
use App\Models\Kluster;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- TAMBAHKAN INI

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
        // REVISI: Bagikan data menu & running text ke semua layout frontend
        View::composer('layouts.*', function ($view) {
            $klusters = Kluster::whereNull('parent_id')
                                ->with('childrenRecursive')
                                ->orderBy('order')
                                ->get();
            $runningText = RunningText::where('is_active', true)->first();

            $view->with('klusters', $klusters)->with('runningText', $runningText);
        });
    }
}
