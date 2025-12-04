<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
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

    private function adminDashboard()
    {
        // Count pending appointments
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        // Get today's on-duty doctors
        $today = now()->format('l'); // Get day name in English
        $hariIndo = $this->getDayInIndonesian($today);
        
        $todayDokters = User::with('poli')
            ->where('role', 'dokter')
            ->whereHas('schedules', function($query) use ($hariIndo) {
                $query->where('hari', $hariIndo);
            })
            ->get();

        // Count users by role
        $userStats = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get()
            ->pluck('total', 'role');

        // Recent appointments
        $recentAppointments = Appointment::with(['pasien', 'dokter.poli'])
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'pending_appointments' => $pendingAppointments,
            'today_dokters' => $todayDokters,
            'user_stats' => $userStats,
            'recent_appointments' => $recentAppointments,
        ]);
    }

    private function dokterDashboard($user)
    {
        // Count pending appointments for this doctor
        $pendingAppointments = Appointment::where('dokter_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Get approved appointments for today
        $todayAppointments = Appointment::with(['pasien', 'jadwal'])
            ->where('dokter_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_booking', today())
            ->get();

        // Get recent patients (5 latest)
        $recentPatients = MedicalRecord::with('pasien')
            ->where('dokter_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->pluck('pasien')
            ->unique('id');

        // Get doctor's schedules
        $schedules = Schedule::where('dokter_id', $user->id)
            ->orderBy('hari')
            ->get();

        return response()->json([
            'pending_appointments' => $pendingAppointments,
            'today_appointments' => $todayAppointments,
            'recent_patients' => $recentPatients,
            'schedules' => $schedules,
        ]);
    }

    private function pasienDashboard($user)
    {
        // Get latest appointment
        $latestAppointment = Appointment::with(['dokter.poli', 'jadwal'])
            ->where('pasien_id', $user->id)
            ->latest()
            ->first();

        // Get approved appointments
        $approvedAppointments = Appointment::with(['dokter.poli', 'jadwal'])
            ->where('pasien_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_booking', '>=', today())
            ->get();

        // Get medical records with prescriptions
        $medicalRecords = MedicalRecord::with(['dokter.poli', 'prescriptions.medicine'])
            ->where('pasien_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'latest_appointment' => $latestAppointment,
            'approved_appointments' => $approvedAppointments,
            'medical_records' => $medicalRecords,
        ]);
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