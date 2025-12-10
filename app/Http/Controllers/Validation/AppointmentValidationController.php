<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentValidationController extends Controller
{
    /**
     * Menampilkan daftar Janji Temu Pending (Untuk Admin/Dokter).
     */
    public function index()
    {
        // Logika untuk Admin: Lihat SEMUA janji temu Pending
        if (auth()->user()->role === 'admin') {
            $appointments = Appointment::where('status', 'Pending')
                                       ->with('patient', 'doctor.poli', 'schedule')
                                       ->orderBy('created_at', 'asc')
                                       ->paginate(15);
                                       
            return view('validation.index', compact('appointments'));
        }
        
        // Logika untuk Dokter: Lihat janji temu Pending yang ditujukan kepadanya
        if (auth()->user()->role === 'dokter') {
            $appointments = Appointment::where('status', 'Pending')
                                       ->where('doctor_id', auth()->id())
                                       ->with('patient', 'doctor.poli', 'schedule')
                                       ->orderBy('created_at', 'asc')
                                       ->paginate(15);
                                       
            return view('validation.index', compact('appointments'));
        }
        
        // Jika bukan Admin atau Dokter, redirect
        return redirect()->back();
    }

    /**
     * Memperbarui status Janji Temu (Approve/Reject).
     */
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status_action' => ['required', 'string', 'in:Approved,Rejected'],
            'alasan_penolakan' => 'required_if:status_action,Rejected|nullable|string|max:255',
        ]);
        
        // Hanya Admin atau Dokter terkait yang boleh memproses
        if (auth()->user()->role !== 'admin' && auth()->id() !== $appointment->doctor_id) {
            abort(403, 'Akses ditolak.');
        }

        $appointment->update([
            'status' => $request->status_action,
            'alasan_penolakan' => $request->status_action === 'Rejected' ? $request->alasan_penolakan : null,
        ]);

        return redirect()->route('validation.index')->with('success', 'Janji Temu berhasil diproses.');
    }
}