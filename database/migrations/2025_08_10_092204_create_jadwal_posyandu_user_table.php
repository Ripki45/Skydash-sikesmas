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
        Schema::create('jadwal_posyandu_user', function (Blueprint $table) {
            $table->id();

            // Kunci yang terhubung ke tabel 'jadwal_posyandus'
            // onDelete('cascade') berarti jika jadwal dihapus, data di sini juga ikut terhapus.
            $table->foreignId('jadwal_posyandu_id')->constrained()->onDelete('cascade');

            // Kunci yang terhubung ke tabel 'users'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_posyandu_user');
    }
};
