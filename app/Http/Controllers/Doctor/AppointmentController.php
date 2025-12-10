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
        $appointments = Appointment::with(['user', 'schedule']) // Load data pasien & jadwal
            ->where('doctor_id', Auth::id())
            ->where('status', 'Pending') // <--- KUNCI: Hanya ambil yang Pending
            ->orderBy('tanggal_booking', 'asc')
            ->get();

        return view('doctor.appointments.index', compact('appointments'));
    }

    // Setujui Janji Temu
    public function approve($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != Auth::id()) abort(403);

        $appointment->update(['status' => 'Approved']); // Ubah jadi Approved

        return redirect()->back()->with('success', 'Janji temu disetujui. Pasien masuk ke antrean konsultasi.');
    }

    // Tolak Janji Temu
    public function reject($id)
    {
        $appointment = Appointment::findOrFail($id);

        if ($appointment->doctor_id != Auth::id()) abort(403);

        $appointment->update(['status' => 'Rejected']);

        return redirect()->back()->with('success', 'Janji temu ditolak.');
    }
}