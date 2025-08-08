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
        // PASTIKAN NAMA TABEL DI SINI ADALAH 'halamans'
        Schema::create('halamans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->string('gambar_unggulan')->nullable();
            $table->enum('status', ['published', 'draft'])->default('draft');
            $table->foreignId('kluster_id')->nullable()->constrained('klusters')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halamans');
    }
};
