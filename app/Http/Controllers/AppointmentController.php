<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    // Menampilkan daftar pasien status 'Pending'
    public function index()
    {
        // Ambil janji temu milik dokter yang sedang login DAN statusnya Pending
        $appointments = Appointment::with(['user', 'schedule']) 
            ->where('doctor_id', Auth::id())
            ->where('status', 'Pending')
            ->orderBy('tanggal_booking', 'asc')
            ->get();

        return view('doctor.appointments.index', compact('appointments'));
    }

    // Mengubah status menjadi Approved
    public function approve($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != Auth::id()) {
            abort(403);
        }

        $appointment->update(['status' => 'Approved']);

        return redirect()->route('doctor.appointments.index')
            ->with('success', 'Janji temu disetujui. Pasien kini masuk ke daftar konsultasi.');
    }

    // Mengubah status menjadi Rejected
    public function reject($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != Auth::id()) {
            abort(403);
        }

        $appointment->update(['status' => 'Rejected']);

        return redirect()->route('doctor.appointments.index')
            ->with('success', 'Janji temu telah ditolak.');
    }
}