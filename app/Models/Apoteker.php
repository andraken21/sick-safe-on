<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apoteker extends Model
{
    protected $table = 'apoteker';
    protected $primaryKey = 'ID_Apoteker';

    protected $fillable = [
        'ID_User',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ID_User', 'ID_User');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'ID_Apoteker', 'ID_Apoteker');
    }
}
