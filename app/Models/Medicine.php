<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    // Pastikan fillable menggunakan nama kolom BAHASA INGGRIS
    protected $fillable = [
        'nama',
        'deskripsi',
        'tipe',
        'stok',
        'harga', // <--- TAMBAHKAN INI
        'gambar',
    ];
       
}