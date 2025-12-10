<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{
    public function index()
    {
        // Masalahnya ada di bagian SELECT di bawah ini
        $appointments = DB::table('appointments')
            ->join('users', 'appointments.patient_id', '=', 'users.id')
            ->join('doctors', 'appointments.doctor_id', '=', 'doctors.id')
            ->join('polis', 'doctors.poli_id', '=', 'polis.id')
            ->select(
                'appointments.*',
                'users.name as nama_pasien',
                'doctors.nama_dokter',
                
                // PERBAIKAN: Ganti 'polis.nama_poli' menjadi 'polis.name as nama_poli'
                // Karena di database kolomnya bernama 'name'
                'polis.name as nama_poli' 
            )
            ->orderBy('appointments.created_at', 'desc')
            ->get();

        return view('admin.appointments.validation', ['appointments' => $appointments]);
    }

    public function updateStatus(Request $request, $id)
    {
        // Update status (Approved / Rejected)
        DB::table('appointments')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}