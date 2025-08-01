<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('roles')->insert([
            [
                'name' => 'superadmin',
                'display_name' => 'Super Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // PENAMBAHAN BARU
            [
                'name' => 'penulis',
                'display_name' => 'Penulis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'bidan',
                'display_name' => 'Bidan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ketua-posyandu',
                'display_name' => 'Ketua Posyandu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'anggota-posyandu',
                'display_name' => 'Anggota Posyandu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
