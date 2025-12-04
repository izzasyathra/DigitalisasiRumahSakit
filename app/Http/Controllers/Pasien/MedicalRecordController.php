<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    // Get patient's medical records
    public function index(Request $request)
    {
        $records = MedicalRecord::with(['dokter.poli', 'appointment', 'prescriptions.medicine'])
            ->where('pasien_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($records);
    }

    // Get single medical record
    public function show($id)
    {
        $record = MedicalRecord::with(['dokter.poli', 'appointment', 'prescriptions.medicine'])
            ->where('pasien_id', auth()->id())
            ->findOrFail($id);

        return response()->json($record);
    }
}