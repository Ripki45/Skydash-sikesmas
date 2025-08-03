<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kluster extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Relasi ke Halaman
    public function halaman()
    {
        return $this->belongsTo(Halaman::class);
    }

    // Relasi ke anak-anaknya (1 level)
    public function children()
    {
        // Pastikan namespace di sini benar: Kluster::class
        return $this->hasMany(Kluster::class, 'parent_id')->orderBy('order');
    }

    // Relasi ke semua keturunannya (multi-level)
    public function childrenRecursive()
    {
       return $this->children()->with('childrenRecursive');
    }
}
