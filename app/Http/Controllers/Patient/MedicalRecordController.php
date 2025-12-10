<?php

namespace App\Http\Controllers\Patient;

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

        return view('pasien.medical-records.index', compact('records'));
    }

    // Get single medical record
    public function show($id)
    {
        $record = MedicalRecord::with(['dokter.poli', 'appointment', 'prescriptions.medicine'])
            ->where('pasien_id', auth()->id())
            ->findOrFail($id);

        return view('pasien.medical-records.show', compact('record'));
    }
}