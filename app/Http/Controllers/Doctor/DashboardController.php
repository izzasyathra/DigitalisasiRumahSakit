<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();

        // 1. Total Pasien 
        $totalPasien = User::where('role', 'pasien')->count();

        // 2. Menunggu Antrean (Janji temu status 'Approved' hari ini yang siap diperiksa)
        $menungguAntrean = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'Approved')
            ->whereDate('tanggal_booking', Carbon::today())
            ->count();

        // 3. Selesai Diperiksa (Janji temu status 'Selesai' hari ini)
        $selesaiDiperiksa = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'Selesai')
            ->whereDate('tanggal_booking', Carbon::today())
            ->count();

        // 4. Data Tabel Antrean (List pasien hari ini yang Approved)
        $antreanTerbaru = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->where('status', 'Approved')
            ->whereDate('tanggal_booking', Carbon::today())
            ->orderBy('created_at', 'asc')
            ->get();

        // Mengirim data ke view
        return view('doctor.dashboard', compact('totalPasien', 'menungguAntrean', 'selesaiDiperiksa', 'antreanTerbaru'));
    }
}