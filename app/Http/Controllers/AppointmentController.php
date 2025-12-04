<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Poli;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Digunakan untuk memproses tanggal dan waktu

class AppointmentController extends Controller
{
    // ===================================
    // FUNGSI PASIEN: BOOKING APPOINTMENT
    // ===================================
    
    /**
     * Step 1: Menampilkan halaman utama booking (Pilih Poli).
     */
    public function showBookingForm()
    {
        $polis = Poli::all();
        // View: resources/views/patient/appointments/booking_step1_poli.blade.php
        return view('patient.appointments.booking_step1_poli', compact('polis'));
    }
    
    /**
     * Step 2: Mengambil Dokter dan Jadwal berdasarkan Poli yang dipilih. (Dipanggil via AJAX/Form)
     */
    public function getDoctorsByPoli(Request $request)
    {
        $poliId = $request->input('poli_id');
        
        $doctors = User::where('poli_id', $poliId)
                       ->where('role', 'Dokter')
                       ->with('schedules')
                       ->get();
                       
        // Mengembalikan daftar dokter yang memiliki jadwal
        return response()->json($doctors->filter(fn($d) => $d->schedules->isNotEmpty()));
    }

    /**
     * Step 3: Menyimpan data Janji Temu (Create Appointment).
     */
    public function storeBooking(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'short_complaint' => 'required|string|max:255',
        ]);
        
        $schedule = Schedule::findOrFail($request->schedule_id);
        $bookingDate = Carbon::parse($request->booking_date);
        
        // 1. Cek kecocokan Hari dan Tanggal yang dipilih Pasien
        if ($bookingDate->dayName !== $schedule->day) {
            return back()->with('error', 'Tanggal yang dipilih tidak sesuai dengan hari jadwal dokter.')->withInput();
        }
        
        // 2. Cek ketersediaan slot (Pastikan slot belum dibooking pada tanggal tsb)
        $isBooked = Appointment::where('doctor_id', $request->doctor_id)
                                ->where('schedule_id', $request->schedule_id)
                                ->where('booking_date', $request->booking_date)
                                ->exists();
                                
        if ($isBooked) {
            return back()->with('error', 'Slot jadwal ini sudah dibooking. Pilih waktu lain.')->withInput();
        }

        Appointment::create([
            'patient_id' => Auth::id(),
            'doctor_id' => $request->doctor_id,
            'schedule_id' => $request->schedule_id,
            'booking_date' => $request->booking_date,
            'short_complaint' => $request->short_complaint,
            'status' => 'Pending', 
        ]);

        return redirect()->route('patient.appointments.index')->with('success', 'Janji Temu berhasil dibuat. Menunggu validasi Dokter/Admin.');
    }
    
    /**
     * Pasien: Melihat riwayat janji temu mereka (View My Appointments).
     */
    public function viewMyAppointments()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
                                   ->with(['doctor.poli', 'schedule'])
                                   ->latest()
                                   ->get();
        // View: resources/views/patient/appointments/index.blade.php
        return view('patient.appointments.index', compact('appointments'));
    }

    // ===================================
    // FUNGSI VALIDASI: DOKTER & ADMIN
    // ===================================

    /**
     * Admin/Dokter: Melihat daftar Janji Temu status "Pending".
     */
    public function viewPendingAppointments()
    {
        $query = Appointment::where('status', 'Pending')->with(['patient', 'doctor', 'schedule']);
        
        if (Auth::user()->isDoctor()) {
            // Jika Dokter: Hanya lihat Janji Temu untuk dirinya sendiri
            $query->where('doctor_id', Auth::id());
        } 

        $pendingAppointments = $query->orderBy('booking_date')->paginate(15);
        
        // Pilih view berdasarkan peran
        $view = Auth::user()->isAdmin() ? 'admin.appointments.pending' : 'doctor.appointments.pending';
        
        return view($view, compact('pendingAppointments'));
    }

    /**
     * Admin/Dokter: Mengubah status menjadi Approved atau Rejected.
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        // Otorisasi: Hanya Admin atau Dokter pemilik janji temu yang bisa validasi
        if (Auth::user()->isDoctor() && $appointment->doctor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki wewenang untuk memvalidasi janji temu ini.');
        }

        $request->validate([
            'status' => ['required', 'string', Rule::in(['Approved', 'Rejected'])],
            'rejection_reason' => ['nullable', 'required_if:status,Rejected', 'string', 'max:500'],
        ]);

        if ($appointment->status !== 'Pending') {
             return back()->with('error', 'Status sudah pernah divalidasi.');
        }

        $appointment->status = $request->status;
        $appointment->rejection_reason = $request->rejection_reason;
        $appointment->save();

        return back()->with('success', 'Status Janji Temu berhasil diperbarui.');
    }
}