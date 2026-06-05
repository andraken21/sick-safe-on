<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
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
    }
}
