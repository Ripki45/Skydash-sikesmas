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
        Schema::create('dusuns', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'desas'
            $table->foreignId('desa_id')->constrained()->onDelete('cascade');
            $table->string('nama_dusun');
            $table->string('nama_posyandu')->nullable(); // Untuk menyimpan nama posyandu di dusun itu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dusuns');
    }
};
