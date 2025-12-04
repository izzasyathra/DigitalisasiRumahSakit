<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'icon',
    ];

    // Relationships
    public function dokters()
    {
        return $this->hasMany(User::class, 'poli_id')->where('role', 'dokter');
    }
}