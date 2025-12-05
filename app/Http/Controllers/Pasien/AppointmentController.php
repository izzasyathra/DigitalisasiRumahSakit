<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Step 1: Select Poli
     */
    public function selectPoli()
    {
        $polis = Poli::withCount('dokters')->get();
        return view('pasien.appointments.select-poli', compact('polis'));
    }

    /**
     * Step 2: Select Doctor from chosen Poli
     */
    public function selectDokter($poliId)
    {
        $poli = Poli::findOrFail($poliId);
        
        // Get doctors with their schedules
        $dokters = User::where('role', 'dokter')
            ->where('poli_id', $poliId)
            ->with('schedules')
            ->get();

        return view('pasien.appointments.select-dokter', compact('poli', 'dokters'));
    }

    /**
     * Step 3: Create appointment form
     */
    public function create(Request $request)
    {
        $dokterId = $request->input('dokter_id');
        $scheduleId = $request->input('schedule_id');

        if (!$dokterId || !$scheduleId) {
            return redirect()->route('pasien.appointments.select-poli')
                ->with('error', 'Silakan pilih dokter dan jadwal terlebih dahulu.');
        }

        $dokter = User::with(['poli', 'schedules'])->findOrFail($dokterId);
        $schedule = Schedule::findOrFail($scheduleId);

        return view('pasien.appointments.create', compact('dokter', 'schedule'));
    }

    /**
     * Store new appointment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan' => 'required|string|max:500',
        ], [
            'dokter_id.required' => 'Dokter harus dipilih',
            'schedule_id.required' => 'Jadwal harus dipilih',
            'tanggal_booking.required' => 'Tanggal booking wajib diisi',
            'tanggal_booking.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu',
            'keluhan.required' => 'Keluhan wajib diisi',
        ]);

        try {
            // Get dokter info for poli_id
            $dokter = User::findOrFail($validated['dokter_id']);

            $appointment = Appointment::create([
                'pasien_id' => Auth::id(),
                'dokter_id' => $validated['dokter_id'],
                'poli_id' => $dokter->poli_id,
                'schedule_id' => $validated['schedule_id'],
                'tanggal_booking' => $validated['tanggal_booking'],
                'keluhan' => $validated['keluhan'],
                'status' => 'pending',
            ]);

            return redirect()->route('pasien.appointments.index')
                ->with('success', 'Janji temu berhasil dibuat! Menunggu validasi dari dokter/admin.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat janji temu. Silakan coba lagi.');
        }
    }

    /**
     * Display all appointments for logged in pasien
     */
    public function index()
    {
        $appointments = Appointment::where('pasien_id', Auth::id())
            ->with(['dokter', 'poli', 'schedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pasien.appointments.index', compact('appointments'));
    }

    /**
     * Show single appointment detail
     */
    public function show($id)
    {
        $appointment = Appointment::where('pasien_id', Auth::id())
            ->where('id', $id)
            ->with(['dokter', 'poli', 'schedule'])
            ->firstOrFail();

        return view('pasien.appointments.show', compact('appointment'));
    }

    /**
     * Cancel appointment
     */
    public function cancel($id)
    {
        $appointment = Appointment::where('pasien_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $appointment->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Janji temu berhasil dibatalkan.');
    }
}