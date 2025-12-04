<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PoliController extends Controller
{
    /**
     * Menampilkan daftar semua Poli. (Akses Admin)
     */
    public function index()
    {
        // Diasumsikan route ini hanya dapat diakses oleh Admin
        $polis = Poli::orderBy('name')->get();

        return view('admin.polis.index', compact('polis'));
    }

    /**
     * Menampilkan formulir untuk membuat Poli baru.
     */
    public function create()
    {
        return view('admin.polis.create');
    }

    /**
     * Menyimpan Poli baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Nama Poli harus unik (sesuai syarat proyek)
            'name' => 'required|string|max:255|unique:polis,name', 
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        Poli::create($validatedData);

        return redirect()->route('admin.polis.index')->with('success', 'Poli baru berhasil ditambahkan.');
    }

    // Metode show() diabaikan (sesuai route kecuali ['show'])

    /**
     * Menampilkan formulir untuk mengedit Poli tertentu.
     */
    public function edit(Poli $poli)
    {
        return view('admin.polis.edit', compact('poli'));
    }

    /**
     * Memperbarui Poli yang sudah ada.
     */
    public function update(Request $request, Poli $poli)
    {
        $validatedData = $request->validate([
            // Nama Poli harus unik, kecuali Poli ini sendiri
            'name' => ['required', 'string', 'max:255', Rule::unique('polis')->ignore($poli->id)], 
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $poli->update($validatedData);

        return redirect()->route('admin.polis.index')->with('success', 'Poli berhasil diperbarui.');
    }

    /**
     * Menghapus Poli.
     */
    public function destroy(Poli $poli)
    {
        try {
            $poli->delete();
            return redirect()->route('admin.polis.index')->with('success', 'Poli berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangani error jika ada Dokter atau Janji Temu yang masih terkait
            return back()->with('error', 'Gagal menghapus Poli. Pastikan tidak ada Dokter atau Janji Temu yang masih terkait.');
        }
    }
}