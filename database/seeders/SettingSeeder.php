<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'nama_puskesmas' => 'Puskesmas Kecamatan Setiabudi',
            'logo_puskesmas' => null,
            'foto_puskesmas' => null,
            'deskripsi' => 'Deskripsi singkat tentang puskesmas...',
            'visi' => 'Visi puskesmas...',
            'misi' => 'Misi puskesmas...',
            'kecamatan' => 'Setiabudi',
            'kepala_puskesmas' => 'Nama Kepala Puskesmas',
            'alamat_lengkap' => 'Alamat lengkap puskesmas...',
            'email' => 'puskesmas@email.com',
            'telepon' => '021-1234567',
            'sosmed_facebook' => 'https://facebook.com',
            'sosmed_instagram' => 'https://instagram.com',
            'sosmed_tiktok' => 'https://tiktok.com',
            'sosmed_youtube' => 'https://youtube.com',
            'lokasi_gmaps' => 'https://maps.google.com',
            'legalitas_sk' => 'Nomor SK/Legalitas...',
        ];

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}
