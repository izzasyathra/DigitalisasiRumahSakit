<?php

namespace Database\Seeders; // PASTI DENGAN D dan S Kapital

use Illuminate\Database\Seeder;
use Database\Seeders\PoliSeeder; // <-- PASTIKAN BARIS INI ADA!
use Database\Seeders\AdminUserSeeder; // <-- PASTIKAN BARIS INI ADA!

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PoliSeeder::class, // Dipanggil setelah di-use di atas
            AdminUserSeeder::class,
        ]);
    }
}