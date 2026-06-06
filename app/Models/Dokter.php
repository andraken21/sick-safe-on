<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
<<<<<<< HEAD
    protected $table = 'dokter';
    protected $primaryKey = 'ID_Dokter';

    protected $fillable = [
        'ID_User',
        'Jenis_kelamin',
        'Spesialis',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_User', 'ID_User');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'ID_Dokter', 'ID_Dokter');
=======
    use HasFactory;

    protected $table      = 'dokter';
    protected $primaryKey = 'id_dokter';

    protected $fillable = [
        'id_user',
        'spesialis',
    ];

    // ── Relasi ──────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'id_dokter', 'id_dokter');
    }

    public function antrian()
    {
        return $this->hasMany(Antrian::class, 'id_dokter', 'id_dokter');
    }

    public function detailResep()
    {
        return $this->hasMany(DetailResep::class, 'id_dokter', 'id_dokter');
    }

    // ── Accessor: rata-rata rating ───────────────────────

    public function getRataRatingAttribute(): float
    {
        return round($this->rating()->avg('rating') ?? 0, 1);
>>>>>>> 64fd7eb8506e9dd968d7932ce49d215139a6ea92
    }
}
