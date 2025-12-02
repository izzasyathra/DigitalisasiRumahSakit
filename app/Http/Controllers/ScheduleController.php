<?php
namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(){ $schedules = auth()->user()->schedules; return view('doctor.schedules.index', compact('schedules')); }
    public function create(){ return view('doctor.schedules.create'); }
    public function store(Request $r){ $r->validate(['day'=>'required','start_time'=>'required']); Schedule::create(['doctor_id'=>auth()->id(),'day'=>$r->day,'start_time'=>$r->start_time,'duration'=>30]); return redirect()->route('doctor.schedules.index')->with('success','Jadwal ditambahkan'); }
    public function destroy(Schedule $schedule){ $this->authorize('delete',$schedule); $schedule->delete(); return back()->with('success','Dihapus'); }
}
