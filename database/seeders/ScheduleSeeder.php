<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\User;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua dokter
        $dokters = User::where('role', 'dokter')->get();

        foreach ($dokters as $dokter) {
            // Buat jadwal untuk setiap dokter
            Schedule::create([
                'dokter_id' => $dokter->id,
                'hari' => 'Senin',
                'jam_mulai' => '08:00:00',
            ]);

            Schedule::create([
                'dokter_id' => $dokter->id,
                'hari' => 'Rabu',
                'jam_mulai' => '10:00:00',
            ]);

            Schedule::create([
                'dokter_id' => $dokter->id,
                'hari' => 'Jumat',
                'jam_mulai' => '14:00:00',
            ]);
        }
    }
}