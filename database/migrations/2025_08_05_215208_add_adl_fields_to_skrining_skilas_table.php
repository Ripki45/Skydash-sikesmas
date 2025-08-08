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
        Schema::table('skrining_skilas', function (Blueprint $table) {
            // Menambahkan kolom-kolom baru setelah 'hb'
            $table->tinyInteger('adl_bab')->nullable()->after('hb');
            $table->tinyInteger('adl_bak')->nullable()->after('adl_bab');
            $table->tinyInteger('adl_membersihkan_diri')->nullable()->after('adl_bak');
            $table->tinyInteger('adl_wc')->nullable()->after('adl_membersihkan_diri');
            $table->tinyInteger('adl_makan_minum')->nullable()->after('adl_wc');
            $table->tinyInteger('adl_berbaring_duduk')->nullable()->after('adl_makan_minum');
            $table->tinyInteger('adl_berjalan')->nullable()->after('adl_berbaring_duduk');
            $table->tinyInteger('adl_berpakaian')->nullable()->after('adl_berjalan');
            $table->tinyInteger('adl_naik_tangga')->nullable()->after('adl_berpakaian');
            $table->tinyInteger('adl_mandi')->nullable()->after('adl_naik_tangga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skrining_skilas', function (Blueprint $table) {
            //
        });
    }
};
