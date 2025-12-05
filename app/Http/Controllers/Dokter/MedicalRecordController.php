<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    // Get approved appointments for today (Antrean Konsultasi)
    public function queue(Request $request)
    {
        $appointments = Appointment::with(['pasien', 'jadwal'])
            ->where('dokter_id', $request->user()->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_booking', today())
            ->get();

        return view('dokter.medical-records.queue', compact('appointments'));
    }

    // Get all medical records created by this doctor
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['pasien', 'appointment', 'prescriptions.medicine'])
            ->where('dokter_id', $request->user()->id);

        // Search by patient name
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('pasien', function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%');
            });
        }

        $records = $query->latest()->paginate(15);

        return view('dokter.medical-records.index', compact('records'));
    }

    public function create(Request $request)
    {
        $appointmentId = $request->query('appointment_id');
        $appointment = null;
        
        if ($appointmentId) {
            $appointment = Appointment::with('pasien')
                ->where('id', $appointmentId)
                ->where('dokter_id', auth()->id())
                ->where('status', 'approved')
                ->firstOrFail();
        }

        $medicines = Medicine::where('stok', '>', 0)->get();

        return view('dokter.medical-records.create', compact('appointment', 'medicines'));
    }

    // Create medical record with prescriptions
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'medicines' => 'required|array|min:1',
            'medicines.*' => 'required|exists:medicines,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1',
        ]);

        // Verify appointment belongs to this doctor and is approved
        $appointment = Appointment::where('id', $request->appointment_id)
            ->where('dokter_id', auth()->id())
            ->where('status', 'approved')
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Create medical record
            $medicalRecord = MedicalRecord::create([
                'appointment_id' => $appointment->id,
                'pasien_id' => $appointment->pasien_id,
                'dokter_id' => auth()->id(),
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
                'catatan' => $request->catatan,
            ]);

            // Create prescriptions
            foreach ($request->medicines as $index => $medicineId) {
                Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'medicine_id' => $medicineId,
                    'jumlah' => $request->quantities[$index],
                ]);
            }

            // Update appointment status to selesai
            $appointment->update(['status' => 'selesai']);

            DB::commit();

            return redirect()->route('dokter.medical-records.index')
                ->with('success', 'Rekam medis berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $record = MedicalRecord::with(['pasien', 'appointment', 'prescriptions.medicine'])
            ->where('dokter_id', auth()->id())
            ->findOrFail($id);

        return view('dokter.medical-records.show', compact('record'));
    }

    public function edit($id)
    {
        $record = MedicalRecord::with('prescriptions')
            ->where('dokter_id', auth()->id())
            ->findOrFail($id);

        $medicines = Medicine::where('stok', '>', 0)->get();

        return view('dokter.medical-records.edit', compact('record', 'medicines'));
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'medicines' => 'nullable|array',
            'medicines.*' => 'required|exists:medicines,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $record->update([
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
                'catatan' => $request->catatan,
            ]);

            // Update prescriptions if provided
            if ($request->has('medicines') && is_array($request->medicines)) {
                // Delete old prescriptions
                $record->prescriptions()->delete();

                // Create new prescriptions
                foreach ($request->medicines as $index => $medicineId) {
                    Prescription::create([
                        'medical_record_id' => $record->id,
                        'medicine_id' => $medicineId,
                        'jumlah' => $request->quantities[$index],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('dokter.medical-records.index')
                ->with('success', 'Rekam medis berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $record = MedicalRecord::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $record->delete();

        return redirect()->route('dokter.medical-records.index')
            ->with('success', 'Rekam medis berhasil dihapus');
    }
}