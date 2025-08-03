<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * REVISI: Beritahu Laravel untuk otomatis mengubah kolom ini menjadi objek tanggal.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime', // <-- TAMBAHKAN INI
    ];

    // Relasi: Satu berita dimiliki oleh satu Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi: Satu berita dimiliki oleh satu User (penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu berita bisa punya banyak Tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
