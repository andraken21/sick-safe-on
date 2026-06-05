<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table      = 'rating';
    protected $primaryKey = 'id_rating';

    protected $fillable = [
        'id_dokter',
        'id_pasien',
        'rating',
    ];

    // ── Relasi ──────────────────────────────────────────

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }
}
