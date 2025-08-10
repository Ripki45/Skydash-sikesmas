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
        Schema::table('pengumumans', function (Blueprint $table) {
            // Perintah untuk menghapus kolom
            $table->dropColumn('konfirmasi_diperlukan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengumumans', function (Blueprint $table) {
            // Perintah untuk mengembalikan kolom jika kita butuh rollback
            $table->boolean('konfirmasi_diperlukan')->default(false);
        });
    }
};
