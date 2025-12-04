<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@digitalhospital.com',
            'password' => Hash::make('password'), 
            'role' => 'admin', 
        ]);

        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'dokter', 
        ]);
        
        
        User::create([
            'name' => 'Pasien Umum',
            'email' => 'pasien@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'pasien', 
        ]);
    }
}