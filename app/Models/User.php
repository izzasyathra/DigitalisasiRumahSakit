<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'birth_date',
        'photo',
        'poli_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationships
    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'dokter_id');
    }

    public function appointmentsAsPasien()
    {
        return $this->hasMany(Appointment::class, 'pasien_id');
    }

    public function appointmentsAsDokter()
    {
        return $this->hasMany(Appointment::class, 'dokter_id');
    }

    public function medicalRecordsAsPasien()
    {
        return $this->hasMany(MedicalRecord::class, 'pasien_id');
    }

    public function medicalRecordsAsDokter()
    {
        return $this->hasMany(MedicalRecord::class, 'dokter_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    public function isPasien()
    {
        return $this->role === 'pasien';
    }
}