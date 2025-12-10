<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\Poli;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $poliUmum = Poli::where('nama_poli', 'Poli Umum')->first();
        $poliGigi = Poli::where('nama_poli', 'Poli Gigi')->first();
        $poliAnak = Poli::where('nama_poli', 'Poli Anak')->first();

        if ($poliUmum) {
            $d1 = Doctor::create([
                'poli_id' => $poliUmum->id,
                'nama_dokter' => 'Dr. Budi Santoso, Sp.PD',
                'spesialisasi' => 'Spesialis Penyakit Dalam',
                'deskripsi_singkat' => 'Pengalaman 10 tahun di bidang penyakit dalam dan diabetes.',
            ]);

            $d1->schedules()->createMany([
                ['hari' => 'Senin', 'jam_mulai' => '08:00:00', 'jam_selesai' => '12:00:00'],
                ['hari' => 'Rabu', 'jam_mulai' => '14:00:00', 'jam_selesai' => '18:00:00'],
            ]);
        }
        
        if ($poliGigi) {
            $d2 = Doctor::create([
                'poli_id' => $poliGigi->id,
                'nama_dokter' => 'Drg. Kartika Sari',
                'spesialisasi' => 'Dokter Gigi Umum',
                'deskripsi_singkat' => 'Fokus pada perawatan ortodontik dan estetika gigi.',
            ]);

            $d2->schedules()->createMany([
                ['hari' => 'Selasa', 'jam_mulai' => '09:00:00', 'jam_selesai' => '13:00:00'],
                ['hari' => 'Kamis', 'jam_mulai' => '09:00:00', 'jam_selesai' => '13:00:00'],
            ]);
        }
        
        if ($poliAnak) {
            $d3 = Doctor::create([
                'poli_id' => $poliAnak->id,
                'nama_dokter' => 'Dr. Vina Maharani, Sp.A',
                'spesialisasi' => 'Spesialis Anak',
                'deskripsi_singkat' => 'Pediatri dengan fokus pada imunisasi dan alergi anak.',
            ]);

            $d3->schedules()->createMany([
                ['hari' => 'Jumat', 'jam_mulai' => '10:00:00', 'jam_selesai' => '14:00:00'],
                ['hari' => 'Sabtu', 'jam_mulai' => '10:00:00', 'jam_selesai' => '12:00:00'],
            ]);
        }
    }
}