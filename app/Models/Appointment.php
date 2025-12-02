<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['patient_id','doctor_id','schedule_id','booking_date','complaint','status','reject_reason'];
    public function patient(){ return $this->belongsTo(User::class,'patient_id'); }
    public function doctor(){ return $this->belongsTo(User::class,'doctor_id'); }
    public function schedule(){ return $this->belongsTo(Schedule::class); }
}
