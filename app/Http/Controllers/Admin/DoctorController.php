<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    /**
     * Menampilkan Daftar Dokter
     */
    public function index()
    {
        // Pastikan role sesuai database ('dokter')
        $doctors = User::where('role', 'dokter')->with('poli')->latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Menampilkan Form Tambah Dokter
     */
    public function create()
    {
        $polis = Poli::all();
        return view('admin.doctors.create', compact('polis'));
    }

    /**
     * Menyimpan Dokter Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Wajib Unique agar tidak error 500 Server Error
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|min:8|confirmed',
            'poli_id' => 'required|exists:polis,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // Gunakan 'dokter' (bukan 'doctor') agar diterima database
            'role' => 'dokter', 
            'poli_id' => $request->poli_id,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    /**
     * Menampilkan Form Edit
     */
    public function edit($id)
    {
        $doctor = User::where('role', 'dokter')->findOrFail($id);
        $polis = Poli::all();
        
        return view('admin.doctors.edit', compact('doctor', 'polis'));
    }

    /**
     * Update Data Dokter
     */
    public function update(Request $request, $id)
    {
        $doctor = User::where('role', 'dokter')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Validasi Unique tapi abaikan email milik dokter ini sendiri
            'email' => ['required', 'email', Rule::unique('users')->ignore($doctor->id)],
            'poli_id' => 'required|exists:polis,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'poli_id' => $request->poli_id,
            'role' => 'dokter', 
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $doctor->update($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Data Dokter berhasil diperbarui!');
    }

    /**
     * Hapus Dokter
     */
    public function destroy($id)
    {
        $doctor = User::where('role', 'dokter')->findOrFail($id);
        $doctor->delete();
        
        return redirect()->route('admin.doctors.index')->with('success', 'Data Dokter berhasil dihapus.');
    }
}