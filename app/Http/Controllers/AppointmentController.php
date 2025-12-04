<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User; // Digunakan untuk relasi Pasien/Dokter

class AppointmentController extends Controller
{
    // ==========================================================
    // FUNGSI DOKTER: VALIDASI JANJI TEMU
    // ==========================================================

    /**
     * Menampilkan daftar Janji Temu 'Pending' yang ditujukan kepada Dokter ini.
     */
    public function validationIndex()
    {
        $doctorId = Auth::id();

        $pendingAppointments = Appointment::where('doctor_id', $doctorId)
                                            ->where('status', 'pending')
                                            ->with('patient', 'poli') 
                                            ->orderBy('booking_date', 'asc')
                                            ->get();

        return view('dokter.appointments.validation', compact('pendingAppointments'));
    }
    
    /**
     * Menyetujui (Approve) Janji Temu.
     */
    public function approve(Appointment $appointment)
    {
        // 1. Pengecekan Kepemilikan dan Status
        if (Auth::id() !== $appointment->doctor_id || $appointment->status !== 'pending') {
            return back()->with('error', 'Janji temu tidak valid untuk disetujui.');
        }

        // 2. Update Status
        $appointment->update(['status' => 'approved']);

        return redirect()->route('dokter.appointments.validation')->with('success', 'Janji temu berhasil disetujui.');
    }

    /**
     * Menolak (Reject) Janji Temu.
     */
    public function reject(Appointment $appointment)
    {
        // 1. Pengecekan Kepemilikan dan Status
        if (Auth::id() !== $appointment->doctor_id || $appointment->status !== 'pending') {
            return back()->with('error', 'Janji temu tidak valid untuk ditolak.');
        }
        
        // 2. Update Status
        $appointment->update(['status' => 'rejected']);

        return redirect()->route('dokter.appointments.validation')->with('success', 'Janji temu berhasil ditolak.');
    }

}