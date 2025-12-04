<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicine::query();

        // Filter by availability
        if ($request->has('available')) {
            if ($request->available == 'true') {
                $query->where('stok', '>', 0);
            } else {
                $query->where('stok', '<=', 0);
            }
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter by type
        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $medicines = $query->latest()->paginate(15);

        return response()->json($medicines);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:keras,biasa',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('medicines', 'public');
            $data['gambar'] = $path;
        }

        $medicine = Medicine::create($data);

        return response()->json([
            'message' => 'Obat berhasil dibuat',
            'medicine' => $medicine,
        ], 201);
    }

    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        return response()->json($medicine);
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:keras,biasa',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'stok' => $request->stok,
        ];

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($medicine->gambar) {
                Storage::disk('public')->delete($medicine->gambar);
            }
            $path = $request->file('gambar')->store('medicines', 'public');
            $data['gambar'] = $path;
        }

        $medicine->update($data);

        return response()->json([
            'message' => 'Obat berhasil diupdate',
            'medicine' => $medicine,
        ]);
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        
        // Delete image if exists
        if ($medicine->gambar) {
            Storage::disk('public')->delete($medicine->gambar);
        }
        
        $medicine->delete();

        return response()->json([
            'message' => 'Obat berhasil dihapus',
        ]);
    }
}