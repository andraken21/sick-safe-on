<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

<<<<<<< HEAD
    protected $primaryKey = 'ID_User';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
=======
    protected $primaryKey = 'id_user';

>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
    protected $fillable = [
        'email',
        'nama',
        'password',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_telp',
        'role',
        'nik',
        'alamat',
        'status',
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

<<<<<<< HEAD
    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'ID_User', 'ID_User');
=======
    // ── Relasi ──────────────────────────────────────────

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'id_user', 'id_user');
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
    }

    public function dokter()
    {
<<<<<<< HEAD
        return $this->hasOne(Dokter::class, 'ID_User', 'ID_User');
=======
        return $this->hasOne(Dokter::class, 'id_user', 'id_user');
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
    }

    public function apoteker()
    {
<<<<<<< HEAD
        return $this->hasOne(Apoteker::class, 'ID_User', 'ID_User');
    }
=======
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
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
}
