<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    // READ: Menampilkan jadwal pribadi Dokter
    public function index()
    {
        $schedules = Schedule::where('user_id', Auth::id())
                              ->orderBy('day')
                              ->orderBy('start_time')
                              ->get();
        return view('dokter.schedule.index', compact('schedules'));
    }

    // CREATE: Menampilkan form buat jadwal
    public function create()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('dokter.schedule.create', compact('days'));
    }

    // CREATE: Menyimpan jadwal baru
    public function store(Request $request)
    {
        $doctorId = Auth::id();
        
        $request->validate([
            'day' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'start_time' => 'required|date_format:H:i',
        ]);
        
        $exists = Schedule::where('user_id', $doctorId)
                          ->where('day', $request->day)
                          ->where('start_time', $request->start_time)
                          ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['start_time' => 'Jadwal tumpang tindih! Dokter sudah memiliki jadwal di slot waktu ini.']);
        }
        
        Schedule::create([
            'user_id' => $doctorId,
            'day' => $request->day,
            'start_time' => $request->start_time . ':00', // Simpan sebagai waktu penuh
        ]);

        return redirect()->route('dokter.schedule.index')->with('success', 'Jadwal praktik berhasil ditambahkan.');
    }

}