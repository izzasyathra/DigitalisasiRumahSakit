<?php

namespace App\Http\Controllers; // Sesuaikan jika ada di folder Admin (misal: App\Http\Controllers\Admin)

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    // 1. Tampilkan Daftar Dokter
    public function index()
    {
        // Kita gunakan JOIN agar bisa mengambil nama poli (bukan cuma ID poli)
        // Ingat: kolom di tabel poli namanya 'name', kita alias-kan jadi 'nama_poli'
        $doctors = DB::table('doctors')
            ->join('polis', 'doctors.poli_id', '=', 'polis.id')
            ->select('doctors.*', 'polis.name as nama_poli') 
            ->orderBy('doctors.created_at', 'desc')
            ->paginate(10);

        return view('admin.doctors.index', compact('doctors'));
    }

    // 2. Form Tambah Dokter
    public function create()
    {
        // Ambil data poli untuk dropdown
        $polis = DB::table('polis')->get();
        return view('admin.doctors.create', compact('polis'));
    }

    // 3. Simpan Dokter Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialisasi' => 'required|string',
            'poli_id' => 'required|exists:polis,id', // Pastikan ID poli ada di tabel polis
        ]);

        Doctor::create([
            'nama_dokter' => $request->nama_dokter,
            'spesialisasi' => $request->spesialisasi,
            'poli_id' => $request->poli_id,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan');
    }

    // 4. Form Edit Dokter
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $polis = DB::table('polis')->get();
        
        return view('admin.doctors.edit', compact('doctor', 'polis'));
    }

    // 5. Update Dokter
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialisasi' => 'required|string',
            'poli_id' => 'required|exists:polis,id',
        ]);

        $doctor = Doctor::findOrFail($id);
        
        $doctor->update([
            'nama_dokter' => $request->nama_dokter,
            'spesialisasi' => $request->spesialisasi,
            'poli_id' => $request->poli_id,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui');
    }

    // 6. Hapus Dokter
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil dihapus');
    }
}