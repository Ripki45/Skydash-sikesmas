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
        Schema::table('dusuns', function (Blueprint $table) {
            // Menghapus kolom yang tidak kita perlukan lagi
            $table->dropColumn('nama_posyandu');
        });
    }

    public function down(): void
    {
        Schema::table('dusuns', function (Blueprint $table) {
            // Ini untuk jaga-jaga jika kita perlu mengembalikan migrasi
            $table->string('nama_posyandu')->nullable()->after('nama_dusun');
        });
    }

};
