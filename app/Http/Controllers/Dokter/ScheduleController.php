<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::where('dokter_id', $request->user()->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        // Check for overlapping schedules
        $exists = Schedule::where('dokter_id', $request->user()->id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'jam_mulai' => ['Jadwal pada hari dan jam ini sudah ada.'],
            ]);
        }

        $schedule = Schedule::create([
            'dokter_id' => $request->user()->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'durasi' => 30, // Fixed 30 minutes
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil dibuat',
            'schedule' => $schedule,
        ], 201);
    }

    public function show($id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);
        
        return response()->json($schedule);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        // Check for overlapping schedules (excluding current)
        $exists = Schedule::where('dokter_id', auth()->id())
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'jam_mulai' => ['Jadwal pada hari dan jam ini sudah ada.'],
            ]);
        }

        $schedule->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
        ]);

        return response()->json([
            'message' => 'Jadwal berhasil diupdate',
            'schedule' => $schedule,
        ]);
    }

    public function destroy($id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);
        
        $schedule->delete();

        return response()->json([
            'message' => 'Jadwal berhasil dihapus',
        ]);
    }
}