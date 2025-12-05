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
    // Show list of polis
    public function selectPoli()
    {
        $polis = Poli::withCount('dokters')->get();
        return view('pasien.appointments.select-poli', compact('polis'));
    }

    // Show doctors by poli
    public function selectDokter($poliId)
    {
        $poli = Poli::findOrFail($poliId);
        $dokters = User::with(['schedules'])
            ->where('role', 'dokter')
            ->where('poli_id', $poliId)
            ->get();

        return view('pasien.appointments.select-dokter', compact('poli', 'dokters'));
    }

    // Show booking form
    public function create(Request $request)
    {
        $dokterId = $request->query('dokter_id');
        $jadwalId = $request->query('jadwal_id');

        if (!$dokterId || !$jadwalId) {
            return redirect()->route('pasien.appointments.select-poli')
                ->with('error', 'Silakan pilih dokter dan jadwal terlebih dahulu');
        }

        $dokter = User::with('poli')->findOrFail($dokterId);
        $jadwal = Schedule::findOrFail($jadwalId);

        // Ensure variables are set
        if (!$dokter || !$jadwal) {
            return redirect()->route('pasien.appointments.select-poli')
                ->with('error', 'Data dokter atau jadwal tidak ditemukan');
        }

        return view('pasien.appointments.create', compact('dokter', 'jadwal'));
    }

    // Store appointment
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

        Appointment::create([
            'pasien_id' => auth()->id(),
            'dokter_id' => $request->dokter_id,
            'jadwal_id' => $request->jadwal_id,
            'tanggal_booking' => $request->tanggal_booking,
            'keluhan' => $request->keluhan,
            'status' => 'pending',
        ]);

        return redirect()->route('pasien.appointments.index')
            ->with('success', 'Janji temu berhasil dibuat. Menunggu konfirmasi dari dokter.');
    }

    // Get patient's appointments
    public function index(Request $request)
    {
        $appointments = Appointment::with(['dokter.poli', 'jadwal', 'medicalRecord'])
            ->where('pasien_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('pasien.appointments.index', compact('appointments'));
    }

    // Get single appointment
    public function show($id)
    {
        $appointment = Appointment::with(['dokter.poli', 'jadwal', 'medicalRecord.prescriptions.medicine'])
            ->where('pasien_id', auth()->id())
            ->findOrFail($id);

        return view('pasien.appointments.show', compact('appointment'));
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

        return redirect()->route('pasien.appointments.index')
            ->with('success', 'Janji temu berhasil dibatalkan');
    }
}