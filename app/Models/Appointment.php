<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke Pasien (User).
     * PENTING: Nama fungsi ini harus 'patient' karena Controller memanggil with('patient').
     */
    public function patient()
    {
        // 'patient_id' adalah nama kolom foreign key di tabel appointments
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Relasi ke User (Opsional/Alias)
     * Jika ada kode lain yang memanggil ->user, biarkan ini ada.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Relasi ke Jadwal (Schedule).
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}