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
        Schema::create('klusters', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama menu, contoh: "Profil"

            // Untuk membuat menu dropdown (menu di dalam menu)
            $table->unsignedBigInteger('parent_id')->nullable();

            // Jika menu ini mau disambungkan ke Halaman dari "Manajemen Halaman"
            $table->unsignedBigInteger('halaman_id')->nullable();

            // Jika menu ini mau diisi link manual (misal: ke google.com)
            $table->string('url')->nullable();

            $table->integer('order')->default(0); // Urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klusters');
    }
};
