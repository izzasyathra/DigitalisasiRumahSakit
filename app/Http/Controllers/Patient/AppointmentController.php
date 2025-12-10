<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Poli;
use App\Models\User;
use App\Models\MedicalRecord; 

class AppointmentController extends Controller
{
    /**
     * Menampilkan Dashboard Pasien (History & Status).
     */
    public function index()
    {
        // Ambil riwayat janji temu pasien
        $appointments = DB::table('appointments')
            ->join('users', 'appointments.doctor_id', '=', 'users.id')
            ->leftJoin('schedules', 'appointments.schedule_id', '=', 'schedules.id')
            ->leftJoin('polis', 'users.poli_id', '=', 'polis.id')
            ->select(
                'appointments.*', 
                'users.name as doctor_name', 
                'polis.name as poli_name', 
                'schedules.start_time', 
                'schedules.end_time'
            )
            ->where('appointments.patient_id', Auth::id())
            ->orderBy('appointments.tanggal_booking', 'desc')
            ->paginate(5); 

        return view('patient.dashboard', compact('appointments'));
    }

    /**
     * Menampilkan halaman buat janji temu.
     */
    public function create()
    {
        $polis = Poli::all();
        $doctors = User::where('role', 'dokter')->get();

        return view('patient.appointments.create', compact('polis', 'doctors'));
    }

    /**
     * Menyimpan janji temu ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'poli_id' => 'required',
            'doctor_id' => 'required',
            'appointment_date' => 'required|date|after_or_equal:today', 
            'complaint' => 'required|string|max:255',
        ]);

        $bookingDate = $request->appointment_date;
        $patientId = Auth::id();

        // 1. Cek duplikasi: Jangan sampai booking double di hari yang sama
        $exists = DB::table('appointments')
            ->where('patient_id', $patientId)
            ->where('tanggal_booking', $bookingDate)
            ->where('status', '!=', 'Rejected') // Kalau ditolak, boleh booking lagi
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah memiliki janji temu aktif pada tanggal tersebut.');
        }

        // 2. Cari Jadwal Dokter (Otomatis deteksi hari)
        $date = Carbon::parse($bookingDate);
        $daysMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu',
        ];
        $hariIndo = $daysMap[$date->format('l')] ?? null;

        $schedule = Schedule::where('doctor_id', $request->doctor_id)
            ->where('day', $hariIndo)
            ->first();

        // Jika dokter tidak praktek hari itu
        if (!$schedule) {
            return back()->withInput()->with('error', "Dokter tidak memiliki jadwal praktik pada hari $hariIndo ($bookingDate). Silakan pilih tanggal lain.");
        }

        // 3. Simpan Data
        DB::table('appointments')->insert([
            'patient_id' => $patientId,
            'doctor_id' => $request->doctor_id,
            'tanggal_booking' => $bookingDate,
            'keluhan_singkat' => $request->complaint,
            'schedule_id' => $schedule->id,
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Janji temu berhasil dibuat! Mohon tunggu konfirmasi dokter.');
    }

    /**
     * Menampilkan Detail Janji Temu & Hasil Rekam Medis
     */
    public function show($id)
    {
        // 1. Ambil data Appointment
        $appointment = DB::table('appointments')
            ->join('users', 'appointments.doctor_id', '=', 'users.id')
            ->leftJoin('schedules', 'appointments.schedule_id', '=', 'schedules.id')
            ->leftJoin('polis', 'users.poli_id', '=', 'polis.id')
            ->select(
                'appointments.*', 
                'users.name as doctor_name', 
                'polis.name as poli_name',
                'schedules.start_time', 
                'schedules.end_time'
            )
            ->where('appointments.id', $id)
            ->where('appointments.patient_id', Auth::id()) // Security check
            ->first();

        if (!$appointment) {
            abort(404);
        }

        // 2. Ambil Rekam Medis (Jika ada)
        $medicalRecord = MedicalRecord::with('medicines')
            ->where('appointment_id', $id)
            ->first();

        return view('patient.appointments.show', compact('appointment', 'medicalRecord'));
    }

    /**
     * AJAX Helper: Ambil Dokter berdasarkan Poli
     */
    public function getDoctorsByPoli($poliId)
    {
        $doctors = User::where('role', 'dokter')
                       ->where('poli_id', $poliId)
                       ->select('id', 'name', 'email') 
                       ->get();
                       
        return response()->json($doctors);
    }
}