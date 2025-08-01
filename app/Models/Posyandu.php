<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }
}
