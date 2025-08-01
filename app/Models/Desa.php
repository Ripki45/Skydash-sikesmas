<?php

namespace App\Models;

use App\Models\Dusun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function dusuns()
    {
        return $this->hasMany(Dusun::class);
    }
}
