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
        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');

            // !! PERBAIKAN UTAMA ADA DI SINI !!
            // Beritahu database bahwa kolom ini boleh kosong (null)
            $table->text('isi')->nullable();

            $table->string('lampiran')->nullable();
            $table->enum('tipe', ['info', 'popup', 'banner'])->default('info');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
    }
};
