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
        Schema::create('pustus', function (Blueprint $table) {
            $table->id(); // Untuk kolom "No."
            $table->string('photo_pustu')->nullable(); // Untuk "Photo Pustu", bisa dikosongi
            $table->string('nama_pustu'); // Untuk "Nama Pustu"
            $table->text('tenaga_kesehatan')->nullable(); // Untuk "Tenaga Kesehatan"
            $table->text('alamat'); // Untuk "Alamat"
            $table->string('jadwal_layanan')->nullable(); // Untuk "Jadwal Layanan"
            $table->string('lokasi_map')->nullable(); // Untuk menyimpan link Google Maps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pustus');
    }
};
