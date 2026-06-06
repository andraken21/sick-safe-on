<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoteker extends Model
{
    use HasFactory;

    protected $table      = 'apoteker';
    protected $primaryKey = 'id_apoteker';

    protected $fillable = [
        'id_user',
    ];

    // ── Relasi ──────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
