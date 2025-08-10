<?php

namespace Database\Seeders;

// 1. Impor Model yang Benar
// Kita hanya butuh Seeder dan Model 'Role' dari package Spatie.
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat peran (roles) awal dalam sistem.
     * Kode ini dirancang khusus untuk package spatie/laravel-permission.
     */
    public function run(): void
    {

        Role::query()->delete();


        Role::create(['name' => 'Super Administrator']);
        Role::create(['name' => 'Penulis']);
        Role::create(['name' => 'Bidan']);
        Role::create(['name' => 'Ketua Posyandu']);
        Role::create(['name' => 'Anggota Posyandu']);
        Role::create(['name' => 'Masyarakat']);
    }
}
