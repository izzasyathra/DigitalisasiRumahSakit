<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use App\Models\User;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'dokter')->with('poli')->get();
        return view('guest.doctors', compact('doctors'));
    }
}