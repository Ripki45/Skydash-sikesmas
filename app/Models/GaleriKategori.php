<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriKategori extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function galeris()
    {
        return $this->hasMany(Galeri::class);
    }
}
