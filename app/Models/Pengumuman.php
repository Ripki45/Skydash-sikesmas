<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

     protected $table = 'pengumumans'; // <--- TAMBAHKAN INI

     protected $fillable = [
    'judul',
    'isi',
    'lampiran',
    'tipe',
    'tanggal_mulai',
    'tanggal_selesai',
    'status',
];

    protected $guarded = ['id'];

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'pengumuman_user');
    }


}
