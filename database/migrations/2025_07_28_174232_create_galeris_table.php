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
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('path_gambar'); // Kolom utama untuk menyimpan path gambar
            $table->string('judul');
            $table->text('keterangan')->nullable(); // Dibuat nullable karena mungkin tidak selalu ada
            $table->string('kategori')->nullable(); // Untuk mengelompokkan foto
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
