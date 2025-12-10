<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;

class PoliManagementController extends Controller
{
    public function getPendingAppointments(Request $request)
    {
        $query = Appointment::with(['pasien', 'dokter.poli', 'jadwal'])
            ->where('status', 'pending');

        $user = $request->user();

        if ($user->isDokter()) {
            $query->where('dokter_id', $user->id);
        }

        // Filter by poli (for admin)
        if ($request->has('poli_id') && $user->isAdmin()) {
            $query->whereHas('dokter', function($q) use ($request) {
                $q->where('poli_id', $request->poli_id);
            });
        }

        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('tanggal_booking', $request->date);
        }

        $appointments = $query->latest()->paginate(15);

        return response()->json($appointments);
    }

    // Approve appointment
    public function approve(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $user = $request->user();

        // Check authorization
        if ($user->isDokter() && $appointment->dokter_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $appointment->update([
            'status' => 'approved',
            'alasan_reject' => null,
        ]);

        return response()->json([
            'message' => 'Janji temu berhasil disetujui',
            'appointment' => $appointment->load(['pasien', 'dokter', 'jadwal']),
        ]);
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
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $appointment->update([
            'status' => 'rejected',
            'alasan_reject' => $request->alasan_reject,
        ]);

        return response()->json([
            'message' => 'Janji temu berhasil ditolak',
            'appointment' => $appointment->load(['pasien', 'dokter', 'jadwal']),
        ]);
    }

    // Get all appointments (for admin)
    public function getAllAppointments(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Appointment::with(['pasien', 'dokter.poli', 'jadwal']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by poli
        if ($request->has('poli_id')) {
            $query->whereHas('dokter', function($q) use ($request) {
                $q->where('poli_id', $request->poli_id);
            });
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_booking', [
                $request->start_date,
                $request->end_date,
            ]);
        }

        $appointments = $query->latest()->paginate(20);

        return response()->json($appointments);
    }
}