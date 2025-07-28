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
        Schema::create('halamans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->string('gambar_unggulan')->nullable(); // Dibuat nullable agar tidak wajib diisi
            $table->string('status')->default('draft'); // 'draft' atau 'published'

            // Menghubungkan ke tabel klusters. onDelete('set null') artinya jika kluster dihapus,
            // halaman ini tidak ikut terhapus, hanya induknya menjadi kosong.
            $table->foreignId('kluster_id')->nullable()->constrained('klusters')->onDelete('set null');

            $table->timestamps(); // Ini akan membuat kolom 'created_at' (Tanggal) dan 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halamen');
    }
};
