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
        Schema::create('skrining_skilas', function (Blueprint $table) {
            $table->id();

            // INFORMASI PENGINPUT
            $table->foreignId('user_id')->constrained()->comment('ID Kader/Bidan yang menginput');
            $table->date('tanggal_skrining');

            // IDENTITAS PASIEN
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_hp')->nullable();
            $table->text('alamat');
            $table->string('rt', 3);
            $table->string('rw', 3);
            $table->string('kelurahan');

            // RIWAYAT PENYAKIT (YA/TIDAK)
            $table->boolean('riwayat_ginjal')->default(false);
            $table->boolean('riwayat_penglihatan')->default(false);
            $table->boolean('riwayat_pendengaran')->default(false);

            // KONSUMSI MAKANAN (YA/TIDAK)
            $table->boolean('konsumsi_pokok')->default(false);
            $table->boolean('konsumsi_lauk')->default(false);
            $table->boolean('konsumsi_sayur')->default(false);
            $table->boolean('konsumsi_buah')->default(false);

            // PEMERIKSAAN FISIK
            $table->integer('td_sistolik')->nullable();
            $table->integer('td_diastolik')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('imt', 4, 2)->nullable();
            $table->decimal('lila', 4, 2)->nullable();

            // LABORATORIUM
            $table->integer('gds')->nullable();
            $table->integer('kolesterol')->nullable();
            $table->decimal('asam_urat', 4, 2)->nullable();
            $table->decimal('hb', 4, 2)->nullable();

            // SKRINING SKILAS (YA/TIDAK - dimana YA adalah jawaban berisiko)
            $table->boolean('skilas_kognitif_tanggal_salah')->default(false);
            $table->boolean('skilas_kognitif_lokasi_salah')->default(false);
            $table->boolean('skilas_kognitif_kata_salah')->default(false);
            $table->boolean('skilas_mobilitas_terbatas')->default(false);
            $table->boolean('skilas_malnutrisi_bb_turun')->default(false);
            $table->boolean('skilas_malnutrisi_nafsu_makan')->default(false);
            $table->boolean('skilas_malnutrisi_lila_rendah')->default(false);
            $table->boolean('skilas_penglihatan_buram')->default(false);
            $table->boolean('skilas_penglihatan_tes_jari')->default(false);
            $table->boolean('skilas_pendengaran_terganggu')->default(false);
            $table->boolean('skilas_depresi_sedih')->default(false);
            $table->boolean('skilas_depresi_kurang_semangat')->default(false);

            // TINDAK LANJUT
            $table->boolean('tindak_lanjut_rujukan')->default(false);
            $table->string('tujuan_rujukan')->nullable();
            $table->text('alasan_rujukan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skrining_skilas');
    }
};
