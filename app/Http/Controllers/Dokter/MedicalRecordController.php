<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    // Get approved appointments for today (Antrean Konsultasi)
    public function getQueue(Request $request)
    {
        $appointments = Appointment::with(['pasien', 'jadwal'])
            ->where('dokter_id', $request->user()->id)
            ->where('status', 'approved')
            ->whereDate('tanggal_booking', today())
            ->get();

        return response()->json($appointments);
    }

    // Get all medical records created by this doctor
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['pasien', 'appointment', 'prescriptions.medicine'])
            ->where('dokter_id', $request->user()->id);

        // Search by patient name
        if ($request->has('search')) {
            $query->whereHas('pasien', function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%');
            });
        }

        $records = $query->latest()->paginate(15);

        return response()->json($records);
    }

    // Create medical record with prescriptions
    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'prescriptions' => 'required|array|min:1',
            'prescriptions.*.medicine_id' => 'required|exists:medicines,id',
            'prescriptions.*.jumlah' => 'required|integer|min:1',
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
            foreach ($request->prescriptions as $prescription) {
                Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'medicine_id' => $prescription['medicine_id'],
                    'jumlah' => $prescription['jumlah'],
                ]);
            }

            // Update appointment status to selesai
            $appointment->update(['status' => 'selesai']);

            DB::commit();

            return response()->json([
                'message' => 'Rekam medis berhasil dibuat',
                'medical_record' => $medicalRecord->load('prescriptions.medicine'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat rekam medis',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $record = MedicalRecord::with(['pasien', 'appointment', 'prescriptions.medicine'])
            ->where('dokter_id', auth()->id())
            ->findOrFail($id);

        return response()->json($record);
    }

    public function update(Request $request, $id)
    {
        $record = MedicalRecord::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $request->validate([
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'catatan' => 'nullable|string',
            'prescriptions' => 'nullable|array',
            'prescriptions.*.medicine_id' => 'required|exists:medicines,id',
            'prescriptions.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $record->update([
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
                'catatan' => $request->catatan,
            ]);

            // Update prescriptions if provided
            if ($request->has('prescriptions')) {
                // Delete old prescriptions
                $record->prescriptions()->delete();

                // Create new prescriptions
                foreach ($request->prescriptions as $prescription) {
                    Prescription::create([
                        'medical_record_id' => $record->id,
                        'medicine_id' => $prescription['medicine_id'],
                        'jumlah' => $prescription['jumlah'],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Rekam medis berhasil diupdate',
                'medical_record' => $record->load('prescriptions.medicine'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal mengupdate rekam medis',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $record = MedicalRecord::where('dokter_id', auth()->id())
            ->findOrFail($id);

        $record->delete();

        return response()->json([
            'message' => 'Rekam medis berhasil dihapus',
        ]);
    }
}