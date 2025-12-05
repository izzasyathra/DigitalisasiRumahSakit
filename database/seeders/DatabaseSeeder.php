<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Poli;
use App\Models\Medicine;
use App\Models\Schedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables
        User::truncate();
        Poli::truncate();
        Medicine::truncate();
        Schedule::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Polis
        $poliUmum = Poli::create([
            'nama' => 'Poli Umum',
            'deskripsi' => 'Pelayanan kesehatan umum untuk berbagai keluhan',
        ]);

        $poliGigi = Poli::create([
            'nama' => 'Poli Gigi',
            'deskripsi' => 'Pelayanan kesehatan gigi dan mulut',
        ]);

        $poliAnak = Poli::create([
            'nama' => 'Poli Anak',
            'deskripsi' => 'Pelayanan kesehatan khusus anak-anak',
        ]);

        $poliMata = Poli::create([
            'nama' => 'Poli Mata',
            'deskripsi' => 'Pelayanan kesehatan mata',
        ]);

        // Create Admin
        User::create([
            'username' => 'admin',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        // Create Doctors
        $dokter1 = User::create([
            'username' => 'dr.budi',
            'email' => 'budi@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'poli_id' => $poliUmum->id,
            'phone' => '081234567891',
            'address' => 'Jl. Kesehatan No. 1',
        ]);

        $dokter2 = User::create([
            'username' => 'dr.siti',
            'email' => 'siti@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'poli_id' => $poliGigi->id,
            'phone' => '081234567892',
            'address' => 'Jl. Kesehatan No. 2',
        ]);

        $dokter3 = User::create([
            'username' => 'dr.ahmad',
            'email' => 'ahmad@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'poli_id' => $poliAnak->id,
            'phone' => '081234567893',
            'address' => 'Jl. Kesehatan No. 3',
        ]);

        // Create Patients
        User::create([
            'username' => 'pasien1',
            'email' => 'pasien1@email.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'phone' => '081234567894',
            'address' => 'Jl. Pasien No. 1',
            'birth_date' => '1990-01-01',
        ]);

        User::create([
            'username' => 'pasien2',
            'email' => 'pasien2@email.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'phone' => '081234567895',
            'address' => 'Jl. Pasien No. 2',
            'birth_date' => '1995-05-15',
        ]);

        // Create Schedules for Doctors
        // Dr. Budi - Senin & Rabu
        Schedule::create([
            'dokter_id' => $dokter1->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'durasi' => 30,
        ]);

        Schedule::create([
            'dokter_id' => $dokter1->id,
            'hari' => 'Senin',
            'jam_mulai' => '10:00:00',
            'durasi' => 30,
        ]);

        Schedule::create([
            'dokter_id' => $dokter1->id,
            'hari' => 'Rabu',
            'jam_mulai' => '09:00:00',
            'durasi' => 30,
        ]);

        // Dr. Siti - Selasa & Kamis
        Schedule::create([
            'dokter_id' => $dokter2->id,
            'hari' => 'Selasa',
            'jam_mulai' => '08:00:00',
            'durasi' => 30,
        ]);

        Schedule::create([
            'dokter_id' => $dokter2->id,
            'hari' => 'Kamis',
            'jam_mulai' => '13:00:00',
            'durasi' => 30,
        ]);

        // Dr. Ahmad - Senin & Jumat
        Schedule::create([
            'dokter_id' => $dokter3->id,
            'hari' => 'Senin',
            'jam_mulai' => '09:00:00',
            'durasi' => 30,
        ]);

        Schedule::create([
            'dokter_id' => $dokter3->id,
            'hari' => 'Jumat',
            'jam_mulai' => '10:00:00',
            'durasi' => 30,
        ]);

        // Create Medicines
        Medicine::create([
            'nama' => 'Paracetamol',
            'deskripsi' => 'Obat penurun panas dan pereda nyeri',
            'tipe' => 'biasa',
            'stok' => 100,
        ]);

        Medicine::create([
            'nama' => 'Amoxicillin',
            'deskripsi' => 'Antibiotik untuk infeksi bakteri',
            'tipe' => 'keras',
            'stok' => 50,
        ]);

        Medicine::create([
            'nama' => 'Vitamin C',
            'deskripsi' => 'Suplemen vitamin C untuk daya tahan tubuh',
            'tipe' => 'biasa',
            'stok' => 200,
        ]);

        Medicine::create([
            'nama' => 'Antasida',
            'deskripsi' => 'Obat untuk mengatasi asam lambung',
            'tipe' => 'biasa',
            'stok' => 75,
        ]);

        Medicine::create([
            'nama' => 'Ciprofloxacin',
            'deskripsi' => 'Antibiotik spektrum luas',
            'tipe' => 'keras',
            'stok' => 30,
        ]);

        $this->command->info('Database seeded successfully!');
    }
}