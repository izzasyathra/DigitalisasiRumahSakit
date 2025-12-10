<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi: Jadwal milik seorang Dokter (User).
     */
    public function doctor()
    {
        // Menghubungkan kolom 'doctor_id' di tabel schedules ke id di tabel users
        return $this->belongsTo(User::class, 'doctor_id');
    }
}