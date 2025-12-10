<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poli; 

class PoliSeeder extends Seeder
{
    public function run(): void
    {

        Poli::create([
            'nama_poli' => 'Poli Umum',
            'deskripsi' => 'Layanan kesehatan untuk penyakit umum dan pencegahan.',
            'ikon_gambar' => null,
        ]);

        Poli::create([
            'nama_poli' => 'Poli Gigi',
            'deskripsi' => 'Perawatan dan pengobatan masalah gigi serta mulut.',
            'ikon_gambar' => null,
        ]);

        Poli::create([
            'nama_poli' => 'Poli Anak',
            'deskripsi' => 'Fokus pada kesehatan dan perkembangan pasien anak.',
            'ikon_gambar' => null,
        ]);
    }
}