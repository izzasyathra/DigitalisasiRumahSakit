<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'polis';

    // TAMBAHKAN INI AGAR BISA DISIMPAN (MASS ASSIGNMENT)
    // Sesuaikan 'name' dan 'description' dengan nama kolom asli di database kamu!
    protected $fillable = [
        'name', 
        'description', // Atau 'deskripsi' jika memang itu namanya (tapi tadi error kan?)
    ];
}