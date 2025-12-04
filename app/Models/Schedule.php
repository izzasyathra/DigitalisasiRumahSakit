<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',          // ID pemilik (Dokter)
        'day',              // Kolom Hari
        'start_time',       // Kolom Jam Mulai
        'duration_minutes', 
    ];
}