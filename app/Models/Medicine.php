<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'tipe',
        'stok',
        'gambar',
    ];

    // Relationships
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'medicine_id');
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->stok > 0;
    }
}