<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['medical_record_id', 'medicine_id', 'jumlah', 'aturan_pakai'];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}