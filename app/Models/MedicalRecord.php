<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'appointment_id',
        'patient_id', 
        'doctor_id',
        'diagnosis',
        'tindakan',
        'catatan',
        'tanggal_berobat',
    ];
    public function doctor() { return $this->belongsTo(User::class, 'doctor_id'); }
    public function patient() { return $this->belongsTo(User::class, 'patient_id'); }
    public function appointment() { return $this->belongsTo(Appointment::class, 'appointment_id'); }
    public function medicines()
{
    return $this->belongsToMany(Medicine::class, 'medical_record_medicine')
                ->withPivot('quantity')
                ->withTimestamps();
}
    // Relasi ke Resep (One to Many)
    public function prescriptions() { return $this->hasMany(Prescription::class); }
}