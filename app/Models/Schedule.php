<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['doctor_id','day','start_time','duration'];
    public function doctor(){ return $this->belongsTo(User::class,'doctor_id'); }
}
