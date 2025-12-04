<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Poli;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Get list of polis for booking
    public function getPolis()
    {
        $polis = Poli::withCount('dokters')->get();
        return response()->json($polis);
    }

    // Get doctors by poli with their schedules
    public function getDoktersByPoli($poliId)
    {
        $dokters = User::with(['schedules'])
            ->where('role', 'dokter')
            ->where('poli_id', $poliId)
            ->get();

        return response()->json($dokters);
    }

    // Get schedule details
    public function getSchedule($scheduleId)
    {
        $schedule = Schedule::with('dokter.poli')->findOrFail($scheduleId);
        return response()->json($schedule);
    }

    // Create appointment
    public function store(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:schedules,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'keluhan' => 'required|string',
        ]);

        // Verify schedule belongs to selected doctor
        $schedule = Schedule::where('id', $request->jadwal_id)
            ->where('dokter_id', $request->dokter_id)
            ->firstOrFail();

        $appointment = Appointment::create([
            'pasien_id' => auth()->id(),
            'dokter_id' => $request->dokter_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal_booking' => $request->tanggal_booking,
            'keluhan' => $request->keluhan,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Janji temu berhasil dibuat',
            'appointment' => $appointment->load(['dokter.poli', 'jadwal']),
        ], 201);
    }

    // Get patient's appointments
    public function index(Request $request)
    {
        $appointments = Appointment::with(['dokter.poli', 'jadwal', 'medicalRecord'])
            ->where('pasien_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($appointments);
    }

    // Get single appointment
    public function show($id)
    {
        $appointment = Appointment::with(['dokter.poli', 'jadwal', 'medicalRecord.prescriptions.medicine'])
            ->where('pasien_id', auth()->id())
            ->findOrFail($id);

        return response()->json($appointment);
    }

    // Cancel appointment (only if pending)
    public function cancel($id)
    {
        $appointment = Appointment::where('pasien_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $appointment->update([
            'status' => 'rejected',
            'alasan_reject' => 'Dibatalkan oleh pasien',
        ]);

        return response()->json([
            'message' => 'Janji temu berhasil dibatalkan',
        ]);
    }
}