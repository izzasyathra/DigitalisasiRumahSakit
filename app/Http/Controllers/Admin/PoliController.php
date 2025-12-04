<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::withCount('dokters')->latest()->get();
        return response()->json($polis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:polis',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('polis', 'public');
            $data['icon'] = $path;
        }

        $poli = Poli::create($data);

        return response()->json([
            'message' => 'Poli berhasil dibuat',
            'poli' => $poli,
        ], 201);
    }

    public function show($id)
    {
        $poli = Poli::with('dokters')->findOrFail($id);
        return response()->json($poli);
    }

    public function update(Request $request, $id)
    {
        $poli = Poli::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|unique:polis,nama,' . $id,
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('icon')) {
            // Delete old icon
            if ($poli->icon) {
                Storage::disk('public')->delete($poli->icon);
            }
            $path = $request->file('icon')->store('polis', 'public');
            $data['icon'] = $path;
        }

        $poli->update($data);

        return response()->json([
            'message' => 'Poli berhasil diupdate',
            'poli' => $poli,
        ]);
    }

    public function destroy($id)
    {
        $poli = Poli::findOrFail($id);
        
        // Delete icon if exists
        if ($poli->icon) {
            Storage::disk('public')->delete($poli->icon);
        }
        
        $poli->delete();

        return response()->json([
            'message' => 'Poli berhasil dihapus',
        ]);
    }
}