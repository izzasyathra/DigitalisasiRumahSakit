<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    // Pastikan nama tabel benar
    protected $table = 'doctors';

    // Daftarkan kolom agar bisa diisi (Mass Assignment)
    protected $fillable = [
        'nama_dokter',
        'spesialisasi',
        'poli_id',
        'no_hp',
        'alamat' 
    ];

    // Relasi ke Poli 
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}