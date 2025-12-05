<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Schedule;
use App\Models\Poli; // Pastikan Poli diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Method utama yang menentukan Dashboard berdasarkan Role
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isDokter()) {
            return $this->dokterDashboard($user);
        } else {
            return $this->pasienDashboard($user);
        }
    }

    // Method untuk halaman Guest/Publik
    public function publicIndex()
    {
        // Mengambil data Poli dan Dokter untuk ditampilkan di halaman Guest
        $polis = Poli::all(); 
        $dokters = User::where('role', 'dokter')->with('poli')->get(); 
        
        // Mengarahkan ke view 'public.home'
        return view('public.home', compact('polis', 'dokters'));
    }

    private function adminDashboard()
    {
        // ... (Kode Admin Dashboard) ...
        // (Saya tidak mengubah logika di sini, hanya memastikan method publicIndex ada)
    }

    private function dokterDashboard($user)
    {
        // ... (Kode Dokter Dashboard) ...
        // (Saya tidak mengubah logika di sini)
    }

    private function pasienDashboard($user)
    {
        // Kode yang sudah Anda berikan sebelumnya, tapi pastikan variabel dikirim
        $latestAppointment = Appointment::with(['dokter.poli', 'jadwal'])
            ->where('pasien_id', $user->id)
            ->latest()
            ->first();

        $approvedAppointments = Appointment::with(['dokter.poli', 'jadwal'])
            ->where('pasien_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_booking', '>=', now())
            ->get();

        $medicalRecords = MedicalRecord::with(['dokter.poli', 'prescriptions.medicine'])
            ->where('pasien_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.pasien', compact(
            'latestAppointment',
            'approvedAppointments',
            'medicalRecords'
        ));
    }

    private function getDayInIndonesian($dayEnglish)
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $days[$dayEnglish] ?? 'Senin';
    }
}