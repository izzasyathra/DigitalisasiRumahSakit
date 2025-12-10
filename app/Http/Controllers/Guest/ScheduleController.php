<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['doctor', 'doctor.poli'])
                    ->orderBy('day', 'desc') 
                    ->get();

        return view('guest.schedules', compact('schedules'));
    }
}