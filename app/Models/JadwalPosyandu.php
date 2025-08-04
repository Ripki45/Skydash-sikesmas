<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPosyandu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * REVISI: Beritahu Laravel untuk otomatis mengubah kolom ini menjadi objek tanggal.
     * Ini akan menyelesaikan error Anda.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_kegiatan' => 'datetime', // <-- TAMBAHKAN INI
    ];

    /**
     * Mendefinisikan bahwa satu jadwal 'milik' satu Posyandu.
     */
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}
