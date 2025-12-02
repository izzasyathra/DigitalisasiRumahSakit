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

    public function store(Request $r)
    {
        $r->validate(['appointment_id'=>'required','diagnosis'=>'required']);
        $a = Appointment::findOrFail($r->appointment_id);
        $mr = MedicalRecord::create([
            'appointment_id'=>$a->id,
            'patient_id'=>$a->patient_id,
            'doctor_id'=>$a->doctor_id,
            'diagnosis'=>$r->diagnosis,
            'action'=>$r->action,
            'note'=>$r->note
        ]);
        $a->status = 'Selesai'; $a->save();
        return redirect()->route('doctor.medical_records.index')->with('success','Rekam medis disimpan');
    }

    public function indexDoctor(){ $records = MedicalRecord::where('doctor_id',auth()->id())->with('appointment.patient')->get(); return view('doctor.medical_records.index', compact('records')); }
}
