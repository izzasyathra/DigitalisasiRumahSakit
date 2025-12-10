<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rs.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // 2. Buat Data Poli
        $poliUmum = Poli::create([
            'name' => 'Poli Umum',
            'description' => 'Pelayanan kesehatan umum',
        ]);
        
        $poliGigi = Poli::create([
            'name' => 'Poli Gigi',
            'description' => 'Pelayanan kesehatan gigi dan mulut',
        ]);

        // 3. Buat Akun Dokter
        User::create([
            'name' => 'dr. Budi Santoso',
            'email' => 'dokterbudi@rs.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'poli_id' => $poliUmum->id, // Relasikan ke Poli Umum
        ]);

        User::create([
            'name' => 'drg. Siti Aminah',
            'email' => 'doktersiti@rs.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'poli_id' => $poliGigi->id, // Relasikan ke Poli Gigi
        ]);

        // 4. Buat Akun Pasien 
        User::create([
            'name' => 'Pasien Contoh',
            'email' => 'pasien@rs.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);
    }
}