<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'poli_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELASI TAMBAHAN ---
    
    // Relasi Poli (Jika User adalah Dokter)
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
    
    // Relasi Appointments (Pasien memiliki banyak janji temu)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id'); // Pasien adalah patient_id
    }

    // Relasi Appointments (Dokter memiliki banyak janji temu)
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id'); // Dokter adalah doctor_id
    }

    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    /**
     * Check if user is Pasien
     */
    public function isPasien()
    {
        return $this->role === 'pasien';
    }
}