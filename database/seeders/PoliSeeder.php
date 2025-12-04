<?php

namespace Database\Seeders;

use App\Models\Poli; 
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poli::create([
            'name' => 'Poli Umum',
            'description' => 'Pelayanan kesehatan umum dan dasar.',
        ]);
        
        Poli::create([
            'name' => 'Poli Anak',
            'description' => 'Spesialisasi kesehatan anak dan tumbuh kembang.',
        ]);
        
        Poli::create([
            'name' => 'Poli Gigi',
            'description' => 'Perawatan dan pengobatan gigi serta mulut.',
        ]);
    }
}