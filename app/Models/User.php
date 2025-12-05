<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /**
     * Relasi ke Poli (untuk Dokter)
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    /**
     * Relasi ke Schedule (Jadwal Dokter)
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'dokter_id');
    }

    /**
     * Relasi ke Appointments sebagai Dokter
     */
    public function appointmentsAsDokter()
    {
        return $this->hasMany(Appointment::class, 'dokter_id');
    }

    /**
     * Relasi ke Appointments sebagai Pasien
     */
    public function appointmentsAsPasien()
    {
        return $this->hasMany(Appointment::class, 'pasien_id');
    }

    /**
     * Relasi ke Medical Records sebagai Dokter
     */
    public function medicalRecordsAsDokter()
    {
        return $this->hasMany(MedicalRecord::class, 'dokter_id');
    }

    /**
     * Relasi ke Medical Records sebagai Pasien
     */
    public function medicalRecordsAsPasien()
    {
        return $this->hasMany(MedicalRecord::class, 'pasien_id');
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Dokter
     */
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