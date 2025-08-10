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
        Schema::create('pengumuman_user', function (Blueprint $table) { // Nama tabel diubah agar konsisten
            $table->id();

            // PERBAIKAN UTAMA ADA DI SINI
            // Kita beritahu Laravel secara eksplisit untuk menyambung ke tabel 'pengumumans'
            $table->foreignId('pengumuman_id')->constrained('pengumumans')->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_user');
    }
};
