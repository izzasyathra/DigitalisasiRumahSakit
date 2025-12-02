<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Poli;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create()
    {
        $polis = Poli::with('doctors')->get();
        return view('patient.appointments.create', compact('polis'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'poli_id'=>'required|exists:polis,id',
            'doctor_id'=>'required|exists:users,id',
            'schedule_id'=>'required|exists:schedules,id',
            'booking_date'=>'required|date',
            'complaint'=>'required|string'
        ]);

        $exists = Appointment::where('doctor_id',$r->doctor_id)
            ->where('schedule_id',$r->schedule_id)
            ->where('booking_date',$r->booking_date)
            ->whereIn('status',['Pending','Approved'])
            ->exists();

        if($exists) return back()->withErrors(['slot'=>'Slot sudah diambil']);

        Appointment::create([
            'patient_id'=>auth()->id(),
            'doctor_id'=>$r->doctor_id,
            'schedule_id'=>$r->schedule_id,
            'booking_date'=>$r->booking_date,
            'complaint'=>$r->complaint,
            'status'=>'Pending'
        ]);

        return redirect()->route('patient.appointments')->with('success','Janji temu dibuat');
    }

    public function indexAdmin(){ $appointments = Appointment::with('patient','doctor','schedule')->orderBy('booking_date')->get(); return view('admin.appointments.index', compact('appointments')); }
    public function indexDoctor(){ $appointments = Appointment::where('doctor_id',auth()->id())->get(); return view('doctor.appointments.index', compact('appointments')); }
    public function indexPatient(){ $appointments = Appointment::where('patient_id',auth()->id())->get(); return view('patient.appointments.index', compact('appointments')); }

    public function approve($id){ $a = Appointment::findOrFail($id); $a->status='Approved'; $a->save(); return back()->with('success','Approved'); }
    public function reject(Request $r,$id){ $a = Appointment::findOrFail($id); $a->status='Rejected'; $a->reject_reason = $r->reason ?? 'Tidak disebutkan'; $a->save(); return back()->with('success','Rejected'); }
}
