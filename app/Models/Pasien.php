<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    // Nama tabel di database
    protected $table = 'pasien';

    // Primary key
    protected $primaryKey = 'ID_Pasien';

    // Kolom yang boleh diisi
    protected $fillable = [
        'ID_User',
        'Jenis_kelamin',
        'Tanggal_Lahir',
        'No_BPJS',
        'Riwayat_Penyakit',
        'Alamat',
    ];

    /**
     * Relasi ke tabel users
     * Pasien BELONGS TO satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ID_User', 'ID_User');
    }

    /**
     * Relasi ke tabel prescriptions (resep)
     * Pasien HAS MANY Resep
     */
    public function reseps()
    {
        return $this->hasMany(Prescription::class, 'ID_Pasien', 'ID_Pasien');
    }

    /**
     * Helper: ambil nama pasien via relasi user
     */
    public function getNamaAttribute()
    {
        return $this->user?->nama ?? '-';
    }

    /**
     * Helper: ambil no_telp pasien via relasi user
     */
    public function getNoTelpAttribute()
    {
        return $this->user?->no_telp ?? '-';
    }
}