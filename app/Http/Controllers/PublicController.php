<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Home page
    public function index()
    {
        $polis = Poli::withCount('dokters')->take(6)->get();
        $dokters = User::with('poli')
            ->where('role', 'dokter')
            ->take(6)
            ->get();

        return view('public.home', compact('polis', 'dokters'));
    }

    // Get all polis
    public function polis()
    {
        $polis = Poli::withCount('dokters')->get();
        return view('public.polis', compact('polis'));
    }

    // Get poli details - INI YANG DIPERBAIKI
    public function poliDetail($id)
    {
        // Cari poli berdasarkan ID
        $poli = Poli::findOrFail($id);

        // Ambil dokter yang terkait dengan poli ini
        $dokters = User::where('role', 'dokter')
                       ->where('poli_id', $id)
                       ->with('schedules')
                       ->get();

        // Kirim kedua variable ke view
        return view('public.poli-detail', compact('poli', 'dokters'));
    }

    // Get all doctors
    public function dokters(Request $request)
    {
        $query = User::with(['poli', 'schedules'])
            ->where('role', 'dokter');

        // Filter by poli
        if ($request->has('poli_id') && $request->poli_id != '') {
            $query->where('poli_id', $request->poli_id);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        $dokters = $query->get();
        $polis = Poli::all(); // For filter

        return view('public.dokters', compact('dokters', 'polis'));
    }

    // Get doctor detail with schedules
    public function dokterDetail($id)
    {
        $dokter = User::with(['poli', 'schedules'])
            ->where('role', 'dokter')
            ->findOrFail($id);

        return view('public.dokter-detail', compact('dokter'));
    }
}