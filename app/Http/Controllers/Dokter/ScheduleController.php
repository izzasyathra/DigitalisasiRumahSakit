<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    // --- 1. READ (Index) ---
    public function index()
    {
        $userId = Auth::id(); 
        
        $schedules = Schedule::where('user_id', $userId)
                                ->orderBy('day')
                                ->orderBy('start_time')
                                ->get();
        
        return view('dokter.schedules.index', compact('schedules'));
    }

    // --- 2. CREATE (View) ---
    public function create()
    {
        return view('dokter.schedules.create'); 
    }

    // --- 3. STORE (Simpan + Validasi Unique Slot) ---
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'day' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => [
                'required', 
                'date_format:H:i',
                // Rule: start_time harus unik untuk user_id DAN hari
                Rule::unique('schedules')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id())
                                 ->where('day', $request->day);
                }),
            ],
            'duration_minutes' => 'required|integer|min:1', 
        ]);

        // Simpan Data
        Schedule::create([
            'user_id' => Auth::id(), 
            'day' => $validatedData['day'],
            'start_time' => $validatedData['start_time'],
            'duration_minutes' => $validatedData['duration_minutes'],
        ]);

        return redirect()->route('schedules.index')->with('success', 'Jadwal praktik berhasil ditambahkan!');
    }

    // --- 4. EDIT (View) ---
    public function edit(Schedule $schedule)
    {
        // Pengecekan Kepemilikan (Penyebab 403 AKSES DITOLAK)
        if (Auth::id() !== $schedule->user_id) { 
            abort(403, 'Akses Ditolak.');
        }
        
        return view('dokter.schedules.edit', compact('schedule'));
    }

    // --- 5. UPDATE (Perbarui) ---
    public function update(Request $request, Schedule $schedule)
    {
        // Pengecekan Auth
        if (Auth::id() !== $schedule->user_id) { 
            abort(403, 'Akses Ditolak.');
        }

        // Validasi, kecualikan jadwal yang sedang diedit
        $validatedData = $request->validate([
            'day' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => [
                'required', 
                'date_format:H:i',
                // Abaikan ID jadwal yang sedang diupdate
                Rule::unique('schedules')->where(function ($query) use ($request) {
                    return $query->where('user_id', Auth::id())
                                 ->where('day', $request->day);
                })->ignore($schedule->id), 
            ],
            'duration_minutes' => 'required|integer|min:1',
        ]);
        
        // UPDATE DATA
        $schedule->update($validatedData);

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    // --- 6. DELETE (Destroy) ---
    public function destroy(Schedule $schedule)
    {
        // Pengecekan Auth
        if (Auth::id() !== $schedule->user_id) { 
            abort(403, 'Akses Ditolak.');
        }

        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}