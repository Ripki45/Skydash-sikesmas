<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    use HasFactory;

    // **
    //  * Secara eksplisit memberitahu Laravel nama tabel yang benar.
    //  */
    protected $table = 'halamans'; // <--- TAMBAHKAN INI

    /**
     * Mengizinkan semua kolom untuk diisi saat membuat data baru.
     */
    protected $guarded = ['id']; // <--- TAMBAHKAN INI JUGA
}
