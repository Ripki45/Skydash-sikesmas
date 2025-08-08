<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    use HasFactory;

    /**
     * REVISI UTAMA: Secara eksplisit memberitahu Laravel nama tabel yang benar.
     * Ini akan menyelesaikan error Anda di semua controller.
     */
    protected $table = 'halamans';

    /**
     * Izinkan semua kolom untuk diisi secara massal.
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
