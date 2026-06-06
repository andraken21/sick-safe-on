<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
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
    }
}
