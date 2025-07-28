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
        Schema::create('sinergi_programs', function (Blueprint $table) {
            $table->id();
            $table->string('gambar_icon');
            $table->string('nama_program'); // Kita ubah namanya agar lebih sesuai
            $table->string('link');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinergi_programs');
    }
};
