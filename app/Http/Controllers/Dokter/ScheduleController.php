<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // LIST SCHEDULE
    public function index(Request $request)
    {
        $schedules = Schedule::where('dokter_id', $request->user()->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('dokter.schedules.index', compact('schedules'));
    }

    // HALAMAN CREATE SCHEDULE
    public function create()
    {
        return view('dokter.schedules.create');
    }

    // DETAIL SCHEDULE
    public function show($id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);

        return view('dokter.schedules.show', compact('schedule'));
    }

    // HALAMAN EDIT
    public function edit($id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);

        return view('dokter.schedules.edit', compact('schedule'));
    }

    // UPDATE JADWAL
    public function update(Request $request, $id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
        ]);

        // CEK JADWAL BENTROK
        $exists = Schedule::where('dokter_id', auth()->id())
            ->where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'jam_mulai' => 'Jadwal pada hari dan jam ini sudah ada.',
            ])->withInput();
        }

        $schedule->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
        ]);

        return redirect()->route('dokter.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    // HAPUS JADWAL
    public function destroy($id)
    {
        $schedule = Schedule::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $schedule->delete();

        return redirect()->route('dokter.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
}
