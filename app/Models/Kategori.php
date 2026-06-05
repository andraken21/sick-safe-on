<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table      = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'kategori_obat',
    ];

    // ── Relasi ──────────────────────────────────────────

    public function obat()
    {
        return $this->hasMany(Obat::class, 'id_kategori', 'id_kategori');
    }
}
