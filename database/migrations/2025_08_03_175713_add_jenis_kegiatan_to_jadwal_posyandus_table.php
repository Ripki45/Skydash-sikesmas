<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_posyandus', function (Blueprint $table) {
            // Tambahkan kolom baru setelah 'posyandu_id'
            $table->string('jenis_kegiatan')->default('Posyandu Balita')->after('posyandu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_posyandus', function (Blueprint $table) {
            //
        });
    }
};
