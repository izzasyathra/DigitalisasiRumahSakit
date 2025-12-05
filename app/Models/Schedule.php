<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'durasi',
    ];

    // Relasi ke tabel users sebagai dokter
    public function doctor()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
