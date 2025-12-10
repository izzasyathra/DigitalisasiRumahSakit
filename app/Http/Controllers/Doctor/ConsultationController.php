<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\MedicalRecord;

class ConsultationController extends Controller
{
    /**
     * Menampilkan daftar pasien yang SUDAH di-approve hari ini
     */
    public function index()
    {
        $appointments = Appointment::with('patient', 'schedule')
            ->where('doctor_id', Auth::id())
            ->where('status', 'Approved')
            ->orderBy('tanggal_booking', 'asc') // Urutkan dari yang terlama
            ->get();

        return view('doctor.consultation.index', compact('appointments'));
    }

    /**
     * Menampilkan Form Pemeriksaan
     */
    public function create($id)
    {
        $appointment = Appointment::with('patient', 'doctor')->findOrFail($id);

        // Security Check: Pastikan ini pasien milik dokter yang login
        if ($appointment->doctor_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pasien ini.');
        }

        // Ambil obat yang stoknya masih ada saja
        $medicines = Medicine::where('stok', '>', 0)->get();

        return view('doctor.consultation.create', compact('appointment', 'medicines'));
    }

    /**
     * Simpan Rekam Medis & Kurangi Stok Obat
     */
    public function store(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'diagnosis' => 'required|string',
            'tindakan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'medicines' => 'nullable|array',         // Obat opsional (bisa cuma konsul)
            'medicines.*' => 'exists:medicines,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'integer|min:1',
        ]);

        // 2. CEK STOK SEBELUM TRANSAKSI (PENTING!)
        if ($request->has('medicines')) {
            foreach ($request->medicines as $index => $medicine_id) {
                $qty_requested = $request->quantities[$index];
                $medicine = Medicine::find($medicine_id);

                if ($medicine->stok < $qty_requested) {
                    return back()->withInput()->with('error', "Stok obat '{$medicine->name}' tidak mencukupi! (Sisa: {$medicine->stok})");
                }
            }
        }

        // 3. Mulai Transaksi Database
        DB::transaction(function() use ($request, $appointment) {
            
            // A. Buat Rekam Medis
            $record = MedicalRecord::create([
                'appointment_id' => $appointment->id,
                'patient_id' => $appointment->patient_id ?? $appointment->user_id, 
                'doctor_id' => Auth::id(),
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan, 
                'catatan' => $request->catatan,   
                'tanggal_berobat' => now(),
            ]);

            // B. Simpan Resep & Kurangi Stok
            if ($request->has('medicines')) {
                foreach ($request->medicines as $index => $medicine_id) {
                    $qty = $request->quantities[$index];

                    $record->medicines()->attach($medicine_id, ['quantity' => $qty]);

                    // Kurangi Stok Real
                    Medicine::where('id', $medicine_id)->decrement('stok', $qty);
                }
            }

            // C. Ubah Status Janji Temu jadi 'Selesai'
            $appointment->update(['status' => 'Selesai']); 
        });

        return redirect()->route('doctor.consultation.index')
            ->with('success', 'Pemeriksaan selesai. Rekam medis berhasil disimpan.');
    }
}