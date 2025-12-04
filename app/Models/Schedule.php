<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'durasi',
    ];

    protected $casts = [
        'jam_mulai' => 'datetime:H:i',
    ];

    // Relationships
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'jadwal_id');
    }
}