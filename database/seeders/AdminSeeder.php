<?php

namespace Database\Seeders;


use App\Models\User; 
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@digitalrs.com', // <-- Gunakan Email ini untuk Login
            'password' => Hash::make('password'), // <-- Password: password
            'role' => 'admin', // <-- Pastikan kolom ini ada di tabel users
        ]);
    }
}