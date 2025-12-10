<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Digunakan untuk penanganan tanggal

class DashboardController extends Controller
{
        public function index()
    {
        $user = Auth::user();
        $data = [];

        switch ($user->role) {
            case 'admin':
                $data = $this->getAdminDashboardData();
                return view('dashboard.admin', $data);

            case 'dokter':
                $data = $this->getDokterDashboardData($user);
                return view('dashboard.dokter', $data);

            case 'pasien':
                $data = $this->getPasienDashboardData($user);
                return view('dashboard.pasien', $data);

            default:
                abort(403, 'Unauthorized');
        }
    }
    
    // =========================================================
    // 1. ADMIN DASHBOARD
    // =========================================================
    private function adminDashboard($user)
    {
        // Default values untuk mencegah Undefined Variable errors
        $userStats = collect(['Admin' => 0, 'Dokter' => 0, 'Pasien' => 0]);
        $latestPending = collect([]);
        $todayDokters = collect([]);
        
        try {
            // Menghitung jumlah user per role
            $userStats = User::select('role', DB::raw('count(*) as total'))
                ->groupBy('role')
                ->get()
                ->pluck('total', 'role');
        } catch (\Exception $e) {}


        try {
            // Janji Temu Pending
            $latestPending = Appointment::with(['patient', 'doctor.poli']) // Asumsi: Relasi pasien/dokter sudah ada
                ->where('status', 'Pending')
                ->latest()
                ->take(10)
                ->get();
        } catch (\Exception $e) {}
        
        try {
             // Dokter yang Bertugas Hari Ini
            $hariIndo = $this->getDayInIndonesian(Carbon::now()->format('l'));
            $todayDokters = User::with('poli')
                ->where('role', 'Dokter')
                ->whereHas('schedules', function($query) use ($hariIndo) {
                    $query->where('day', $hariIndo); // Asumsi: kolom di tabel schedules bernama 'day'
                })
                ->get();
        } catch (\Exception $e) {}

        return view('dashboard.admin', compact(
            'latestPending',
            'todayDokters',
            'userStats'
        ));
    }

    // =========================================================
    // 2. DOKTER DASHBOARD
    // =========================================================
    private function dokterDashboard($user)
    {
        $doctorId = $user->id;
        $today = Carbon::today();
        
        $pendingAppointments = 0;
        $todayAppointments = collect([]);
        $recentPatients = collect([]);
        $schedules = collect([]);

        try {
            // Count pending appointments for this doctor
            $pendingAppointments = Appointment::where('doctor_id', $doctorId) // Asumsi: foreign key 'doctor_id'
                ->where('status', 'Pending')
                ->count();

            // Get approved appointments for today
            $todayAppointments = Appointment::with(['patient']) // Asumsi: Relasi pasien sudah ada
                ->where('doctor_id', $doctorId)
                ->where('status', 'Approved')
                ->whereDate('booking_date', $today) // Asumsi: kolom booking_date
                ->get();

            // Get recent patients (5 latest)
            $recentPatients = MedicalRecord::with('patient')
                ->where('doctor_id', $doctorId)
                ->latest()
                ->take(5)
                ->get();
            
            // Get doctor's schedules
            $schedules = Schedule::where('user_id', $doctorId) // Asumsi: foreign key 'user_id'
                ->orderBy('day')
                ->get();
                
        } catch (\Exception $e) { /* Error handling, tetap kembalikan default */ }


        return view('dashboard.dokter', compact(
            'pendingAppointments',
            'todayAppointments',
            'recentPatients',
            'schedules'
        ));
    }

    // =========================================================
    // 3. PASIEN DASHBOARD
    // =========================================================
    private function pasienDashboard($user)
    {
        $patientId = $user->id;

        $latestAppointment = null;
        $upcomingAppointments = collect([]);
        $medicalRecords = collect([]);

        try {
            // Get latest appointment with relations
            $latestAppointment = Appointment::with(['doctor.poli']) // Asumsi: Relasi doctor/poli sudah ada
                ->where('patient_id', $patientId) // Asumsi: foreign key 'patient_id'
                ->latest()
                ->first();

            // Get approved upcoming appointments
            $upcomingAppointments = Appointment::with(['doctor.poli'])
                ->where('patient_id', $patientId)
                ->where('status', 'Approved')
                ->whereDate('booking_date', '>=', Carbon::today())
                ->get();

            // Get medical records
            $medicalRecords = MedicalRecord::with('doctor.poli')
                ->where('patient_id', $patientId)
                ->latest()
                ->take(5)
                ->get();
                
        } catch (\Exception $e) { /* Error handling, tetap kembalikan default */ }

        return view('dashboard.pasien', compact(
            'latestAppointment',
            'upcomingAppointments',
            'medicalRecords'
        ));
    }

    // =========================================================
    // 4. HELPER FUNCTION
    // =========================================================
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