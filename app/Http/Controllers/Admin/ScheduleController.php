<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal praktik.
     */
    public function index()
    {
        // Ambil semua jadwal, urutkan berdasarkan hari (custom sort jika perlu)
        $schedules = Schedule::with('user.poli') // Load Dokter dan Poli Dokter
                               ->orderBy('day', 'asc')
                               ->paginate(15);
                               
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('admin.schedules.index', compact('schedules', 'days'));
    }

    /**
     * Menampilkan formulir pembuatan jadwal.
     */
    public function create()
    {
        // Hanya ambil user dengan role 'dokter'
        $doctors = User::where('role', 'dokter')->with('poli')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        if ($doctors->isEmpty()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda harus memiliki setidaknya satu Dokter terdaftar sebelum membuat jadwal.');
        }

        return view('admin.schedules.create', compact('doctors', 'days'));
    }

    /**
     * Menyimpan data jadwal baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'day' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'start_time' => 'required|date_format:H:i', // HH:MM
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        
        // Cek duplikasi jadwal untuk user_id dan day yang sama
        $isDuplicate = Schedule::where('user_id', $validated['user_id'])
                               ->where('day', $validated['day'])
                               ->exists();
                               
        if ($isDuplicate) {
            return back()->withInput()->withErrors(['day' => 'Dokter ini sudah memiliki jadwal pada hari yang sama.']);
        }

        Schedule::create($validated);
        
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal praktik berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit jadwal.
     */
    public function edit(Schedule $schedule)
    {
        $doctors = User::where('role', 'dokter')->with('poli')->get();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('admin.schedules.edit', compact('schedule', 'doctors', 'days'));
    }

    /**
     * Memperbarui data jadwal.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'day' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
        
        // Cek duplikasi jadwal, kecuali jadwal yang sedang diedit
        $isDuplicate = Schedule::where('user_id', $validated['user_id'])
                               ->where('day', $validated['day'])
                               ->where('id', '!=', $schedule->id) // Abaikan ID saat ini
                               ->exists();
                               
        if ($isDuplicate) {
            return back()->withInput()->withErrors(['day' => 'Dokter ini sudah memiliki jadwal pada hari yang sama.']);
        }

        $schedule->update($validated);
        
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal praktik berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal praktik berhasil dihapus.');
    }
}