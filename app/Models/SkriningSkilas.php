<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkriningSkilas extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara eksplisit untuk menghindari kesalahan Laravel
    protected $table = 'skrining_skilas';

    // Izinkan semua kolom untuk diisi
    protected $guarded = ['id'];

    /**
     * Mendefinisikan bahwa satu data skrining 'milik' satu User (penginput).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
