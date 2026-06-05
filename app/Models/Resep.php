<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table      = 'resep';
    protected $primaryKey = 'id_resep';

    protected $fillable = [];

    // ── Relasi ──────────────────────────────────────────

    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'id_resep', 'id_resep');
    }

    public function detailResep()
    {
        return $this->hasOne(DetailResep::class, 'id_resep', 'id_resep');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_resep', 'id_resep');
    }

    // ── Accessor: hitung total jenis obat ───────────────

    public function getTotalObatAttribute(): int
    {
        return $this->resepObat()->count();
    }
}
