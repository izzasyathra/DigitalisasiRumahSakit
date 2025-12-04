<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Get all polis (public)
    public function getPolis()
    {
        $polis = Poli::withCount('dokters')->get();
        return response()->json($polis);
    }

    // Get poli details
    public function getPoliDetail($id)
    {
        $poli = Poli::with(['dokters' => function($query) {
            $query->with('schedules');
        }])->findOrFail($id);

        return response()->json($poli);
    }

    // Get all doctors (public)
    public function getDokters(Request $request)
    {
        $query = User::with(['poli', 'schedules'])
            ->where('role', 'dokter');

        // Filter by poli
        if ($request->has('poli_id')) {
            $query->where('poli_id', $request->poli_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        $dokters = $query->get();

        return response()->json($dokters);
    }

    // Get doctor detail with schedules
    public function getDokterDetail($id)
    {
        $dokter = User::with(['poli', 'schedules'])
            ->where('role', 'dokter')
            ->findOrFail($id);

        return response()->json($dokter);
    }
}