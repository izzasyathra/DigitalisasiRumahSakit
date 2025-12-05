<?php
namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function createFromAppointment($appointmentId)
    {
        $appointment = Appointment::with('patient','doctor')->findOrFail($appointmentId);
        return view('doctor.medical_records.create', compact('appointment'));
    }

    public function store(Request $request)
{
    $request->validate([
        'appointment_id'=>'required|exists:appointments,id',
        'diagnosis'=>'required|string',
        'treatment'=>'nullable|string',
        'prescriptions'=>'nullable|array',
        'prescriptions.*.medicine_id'=>'required|exists:medicines,id',
        'prescriptions.*.quantity'=>'required|integer|min:1'
    ]);

    $appointment = Appointment::findOrFail($request->appointment_id);
    // only doctor assigned can save
    if(auth()->id() !== $appointment->doctor_id) abort(403);

    $mr = MedicalRecord::create([
        'patient_id'=>$appointment->patient_id,
        'doctor_id'=>$appointment->doctor_id,
        'appointment_id'=>$appointment->id,
        'diagnosis'=>$request->diagnosis,
        'treatment'=>$request->treatment,
        'notes'=>$request->notes,
        'visit_date'=>now()
    ]);

    if($request->filled('prescriptions')){
        foreach($request->prescriptions as $p){
            Prescription::create([
                'medical_record_id'=>$mr->id,
                'medicine_id'=>$p['medicine_id'],
                'quantity'=>$p['quantity']
            ]);
            // reduce stock
            $med = Medicine::find($p['medicine_id']);
            $med->decrement('stock', $p['quantity']);
        }
    }

    $appointment->status = 'done';
    $appointment->save();

    return redirect()->route('doctor.dashboard')->with('success','Rekam medis tersimpan');
}
}
