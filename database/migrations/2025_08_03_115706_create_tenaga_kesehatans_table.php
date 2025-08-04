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
        Schema::create('tenaga_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('nip_nik')->unique()->nullable();
            $table->string('jabatan'); // Contoh: Dokter Umum, Bidan, Perawat
            $table->string('spesialisasi')->nullable(); // Contoh: Gigi, Anak
            $table->string('jadwal_praktik')->nullable(); // Teks bebas, misal: Senin & Rabu, 08:00 - 12:00
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kesehatans');
    }
};
