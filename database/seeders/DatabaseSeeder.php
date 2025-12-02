<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
use App\Models\User;

public function run(): void
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@hospital.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin',
    ]);
}


    }

