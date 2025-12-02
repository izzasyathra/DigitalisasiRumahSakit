<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','email','password','role','poli_id','avatar'];
    protected $hidden = ['password','remember_token'];

    public function poli(){ return $this->belongsTo(Poli::class); }
    public function schedules(){ return $this->hasMany(Schedule::class,'doctor_id'); }
    public function appointmentsAsPatient(){ return $this->hasMany(Appointment::class,'patient_id'); }
    public function appointmentsAsDoctor(){ return $this->hasMany(Appointment::class,'doctor_id'); }
}
