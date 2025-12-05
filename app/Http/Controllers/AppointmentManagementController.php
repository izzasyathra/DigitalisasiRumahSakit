<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Poli;
use Illuminate\Http\Request;

class AppointmentManagementController extends Controller
{
    // Get pending appointments (Admin sees all, Dokter sees only theirs)
    public function index(Request $request)
    {
        $query = Appointment::with(['pasien', 'dokter.poli', 'jadwal'])
            ->where('status', 'pending');

        $user = $request->user();

        // If dokter, only show their appointments
        if ($user->isDokter()) {
            $query->where('dokter_id', $user->id);
        }

        // Filter by poli (for admin)
        if ($request->has('poli_id') && $request->poli_id != '' && $user->isAdmin()) {
            $query->whereHas('dokter', function($q) use ($request) {
                $q->where('poli_id', $request->poli_id);
            });
        }

        // Filter by date
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('tanggal_booking', $request->date);
        }

        $appointments = $query->latest()->paginate(15);
        $polis = Poli::all(); // For filter dropdown

        return view('appointments.pending', compact('appointments', 'polis'));
    }

    // Approve appointment
    public function approve(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $user = $request->user();

        // Check authorization
        if ($user->isDokter() && $appointment->dokter_id !== $user->id) {
            return back()->with('error', 'Unauthorized');
        }

        $appointment->update([
            'status' => 'approved',
            'alasan_reject' => null,
        ]);

        return back()->with('success', 'Janji temu berhasil disetujui');
    }

    // Show reject form
    public function showRejectForm($id)
    {
        $appointment = Appointment::with(['pasien', 'dokter.poli', 'jadwal'])
            ->findOrFail($id);
        
        $user = auth()->user();

        // Check authorization
        if ($user->isDokter() && $appointment->dokter_id !== $user->id) {
            return back()->with('error', 'Unauthorized');
        }

        return view('appointments.reject', compact('appointment'));
    }

    // Reject appointment
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_reject' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($id);
        
        $user = $request->user();

        // Check authorization
        if ($user->isDokter() && $appointment->dokter_id !== $user->id) {
            return back()->with('error', 'Unauthorized');
        }

        $appointment->update([
            'status' => 'rejected',
            'alasan_reject' => $request->alasan_reject,
        ]);

        return redirect()->route('appointments.pending')
            ->with('success', 'Janji temu berhasil ditolak');
    }

    // Get all appointments (for admin)
    public function allAppointments(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        $query = Appointment::with(['pasien', 'dokter.poli', 'jadwal']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by poli
        if ($request->has('poli_id') && $request->poli_id != '') {
            $query->whereHas('dokter', function($q) use ($request) {
                $q->where('poli_id', $request->poli_id);
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date != '' 
            && $request->has('end_date') && $request->end_date != '') {
            $query->whereBetween('tanggal_booking', [
                $request->start_date,
                $request->end_date,
            ]);
        }

        $appointments = $query->latest()->paginate(20);
        $polis = Poli::all();

        return view('appointments.all', compact('appointments', 'polis'));
    }
}