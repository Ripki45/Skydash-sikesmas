<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinergiProgram extends Model
{
    use HasFactory;

    // Tambahkan baris ini
    protected $guarded = ['id'];
}
