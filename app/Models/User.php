<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'ID_User';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'ID_User', 'ID_User');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'ID_User', 'ID_User');
    }

    public function apoteker()
    {
        return $this->hasOne(Apoteker::class, 'ID_User', 'ID_User');
    }
}
