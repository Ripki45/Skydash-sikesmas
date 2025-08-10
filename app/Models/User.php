<?php

namespace App\Models;

use App\Models\Pengumuman;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * INILAH "KACAMATA SUPER" UNTUK EDITOR
 * Ini memberitahu editor tentang SEMUA properti dan relasi yang dimiliki User.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Pengumuman[] $confirmedPengumumans
 * @property-read \App\Models\Desa|null $desa
 * @property-read \App\Models\Dusun|null $dusun
 * @property-read \App\Models\Posyandu|null $posyandu
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Berita[] $beritas
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public function confirmedPengumumans()
    {
        return $this->belongsToMany(Pengumuman::class, 'pengumuman_user', 'user_id', 'pengumuman_id');
    }

    /**
     * Kolom yang boleh diisi mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'desa_id',
        'dusun_id',
        'posyandu_id',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting kolom ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi Wilayah
    |--------------------------------------------------------------------------
    */

    public function desa()
    {
        return $this->belongsTo(Desa::class);
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Konten
    |--------------------------------------------------------------------------
    */

    public function beritas()
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * Mendefinisikan relasi ke Jadwal Posyandu yang sudah dikonfirmasi oleh User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function confirmedJadwals()
    {
        return $this->belongsToMany(JadwalPosyandu::class);
    }


}
