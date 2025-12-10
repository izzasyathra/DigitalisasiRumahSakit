<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        // Ambil jadwal beserta data dokter dan polinya
        $schedules = Schedule::with(['doctor', 'doctor.poli'])
                    ->orderBy('day', 'desc') // Atau urutkan sesuai kebutuhan
                    ->get();

        return view('guest.schedules', compact('schedules'));
    }
}