<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\Schedule;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        $userId = $user->id;
        $pendingAppointments = collect([]);
        $approvedAppointments = collect([]);
        $latestPatients = collect([]);
        $schedules = collect([]);

        if ($user->role === 'Admin') { 
            return view('dashboard.admin');
        } 
        
        elseif ($user->role === 'dokter') { 
            try {
                $pendingAppointments = Appointment::where('doctor_id', $userId)
                                                    ->where('status', 'Pending')
                                                    ->with('patient')
                                                    ->get();
            } catch (\Exception $e) {} 

            return view('dashboard.dokter', compact(
                'pendingAppointments', 
                'approvedAppointments', 
                'latestPatients',
                'schedules'
            ));
        }
    }
}