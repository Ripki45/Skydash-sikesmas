<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pustu extends Model
{
    use HasFactory;

    /**
     * Secara eksplisit memberitahu Laravel nama tabel yang benar.
     */
    protected $table = 'pustus'; // <-- TAMBAHKAN INI

    /**
     * The attributes that aren't mass assignable.
     */
    protected $guarded = ['id'];
}
