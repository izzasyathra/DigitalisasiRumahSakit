<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('doctor_id', Auth::id())->paginate(10);
        return view('doctor.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('doctor.schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        // Cek duplikasi hari 
        $exists = Schedule::where('doctor_id', Auth::id())
            ->where('day', $request->day)
            ->exists();

        if ($exists) {
            return back()->withErrors(['day' => 'Jadwal untuk hari tersebut sudah ada.']);
        }

        // Simpan data 
        Schedule::create([
            'doctor_id' => Auth::id(),
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('doctor.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('doctor.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        // Pastikan hanya pemilik yang bisa edit
        if ($schedule->doctor_id != Auth::id()) abort(403);

        $schedule->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('doctor.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // --- BAGIAN HAPUS ---
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        // Security Check: Pastikan jadwal milik dokter yang login
        if ($schedule->doctor_id != Auth::id()) {
            abort(403);
        }

        $schedule->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}