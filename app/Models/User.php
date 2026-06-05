<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'email',
        'nama',
        'nama',
        'password',
        'tanggal_lahir',
        'jenis_kelamin',
        'jenis_kelamin',
        'no_telp',
        'role',
        'nik',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'password'      => 'hashed',
        ];
    }

    // ── Relasi ──────────────────────────────────────────

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_user', 'id_user');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_user', 'id_user');
    }

    public function apoteker()
    {
        return $this->hasOne(Apoteker::class, 'id_user', 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user', 'id_user');
    }

    // ── Helper role ──────────────────────────────────────

    public function isPasien(): bool  { return $this->role === 'Pasien'; }
    public function isDokter(): bool  { return $this->role === 'Dokter'; }
    public function isApoteker(): bool { return $this->role === 'Apoteker'; }
    public function isAdmin(): bool   { return $this->role === 'Admin'; }
}