<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kluster extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function children()
    {
        return $this->hasMany(Kluster::class, 'parent_id')->orderBy('order');
    }
}
