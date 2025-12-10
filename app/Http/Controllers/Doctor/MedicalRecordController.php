<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MedicalRecordController extends Controller
{
    /**
     * Halaman Utama: Menampilkan Antrean Konsultasi (Janji Temu Approved hari ini)
     */
    public function index()
    {
        $queueAppointments = Appointment::where('doctor_id', auth()->id())
                                        ->where('status', 'Approved')
                                        ->whereDate('tanggal_booking', Carbon::today()) 
                                        ->with('patient', 'schedule')
                                        ->orderBy('schedule_id')
                                        ->get();
                                        
        return view('doctor.medical_records.queue', compact('queueAppointments'));
    }

    /**
     * Menampilkan formulir pembuatan Rekam Medis (saat konsultasi).
     */
    public function create($appointment_id)
    {
        // 1. Cari data janji temu berdasarkan ID
        $appointment = Appointment::with('patient', 'doctor')->findOrFail($appointment_id);

        // 2. Tampilkan view form pemeriksaan & kirim data appointment
        return view('doctor.medical_records.create', compact('appointment'));
    }

    /**
     * Menyimpan Rekam Medis dan Resep baru.
     */
    public function store(Request $request, Appointment $appointment)
    {
        // 1. Validasi Data Input Dokter
        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string',
            'medicine' => 'nullable|string',
        ]);

        // 2. Simpan Rekam Medis Baru
        MedicalRecord::create([
            'patient_id' => $appointment->patient_id, 
            'doctor_id' => Auth::id(),
            'appointment_id' => $appointment->id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'medicine_prescription' => $request->medicine, 
        ]);

        // 3. Update Status Janji Temu
        $appointment->status = 'Completed'; 
        $appointment->save();

        // 4. Redirect dan Beri Pesan Sukses
        return redirect()->route('doctor.dashboard')->with('success', 
            'Pemeriksaan untuk pasien ' . $appointment->patient->name . ' telah berhasil disimpan.'
        );
    } 

    public function showPatientHistory($patientId)
    {
        $patient = User::findOrFail($patientId);
        
        $medicalRecords = MedicalRecord::where('patient_id', $patientId)
                                       
                                       ->orderBy('created_at', 'desc') 
                                       ->get();
                                       
        return view('doctor.medical_records.history', compact('patient', 'medicalRecords'));
    }
}