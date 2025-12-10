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
        'no_hp', // Tambahkan jika ada di DB, jika tidak hapus baris ini
        'alamat' // Tambahkan jika ada di DB, jika tidak hapus baris ini
    ];

    // Relasi ke Poli (Opsional, tapi bagus untuk kerapian)
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }
}