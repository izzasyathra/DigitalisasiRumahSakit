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
        if ($request->has('available') && $request->available != '') {
            if ($request->available == 'true') {
                $query->where('stok', '>', 0);
            } else {
                $query->where('stok', '<=', 0);
            }
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter by type
        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        $medicines = $query->latest()->paginate(15);

        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
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

        Medicine::create($data);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil dibuat');
    }

    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('admin.medicines.show', compact('medicine'));
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('admin.medicines.edit', compact('medicine'));
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

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil diupdate');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        
        // Delete image if exists
        if ($medicine->gambar) {
            Storage::disk('public')->delete($medicine->gambar);
        }
        
        $medicine->delete();

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}