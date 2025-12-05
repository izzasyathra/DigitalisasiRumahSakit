<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    /**
     * Relasi ke User (Dokter)
     * Satu Poli memiliki banyak Dokter
     */
    public function dokters()
    {
        return $this->hasMany(User::class, 'poli_id')
                    ->where('role', 'dokter');
    }

    /**
     * Get jumlah dokter di poli ini
     */
    public function dokters_count()
    {
        return $this->dokters()->count();
    }
}