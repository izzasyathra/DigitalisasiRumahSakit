<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    /**
     * Menampilkan daftar semua Poli (List Poli).
     */
    public function index()
{
    // Ganti 'name' dengan nama kolom yang kamu temukan tadi!
    $polis = Poli::orderBy('name', 'asc')->paginate(10);
    return view('admin.poli.index', compact('polis'));
}

    /**
     * Menampilkan formulir pembuatan Poli (Create Poli).
     */
    public function create()
    {
        return view('admin.poli.create');
    }

    /**
     * Menyimpan data Poli baru (Create Poli).
     */
    public function store(Request $request)
    {
        $request->validate([
            // Pastikan unique mengecek kolom 'name'
            'nama_poli' => 'required|string|max:255|unique:polis,name',
            'deskripsi' => 'nullable|string',
        ]);

        Poli::create([
            // Kiri: Nama Kolom Database | Kanan: Nama Input Form HTML
            'name'        => $request->nama_poli, 
            'description' => $request->deskripsi, // Ganti 'description' sesuai nama kolom DB kamu
        ]);

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil ditambahkan.');
    }
    /**
     * Menampilkan formulir edit Poli.
     */
    public function edit(Poli $poli)
    {
        return view('admin.poli.edit', compact('poli'));
    }

    /**
     * Memperbarui data Poli (Edit Poli).
     */
   public function update(Request $request, Poli $poli)
    {
        $request->validate([
            // PERBAIKAN 1: Validasi Unique
            // Format: unique:nama_tabel,nama_kolom_database,id_yang_dikecualikan
            // Kita harus ubah parameter ke-2 menjadi 'name' (sesuai kolom DB)
            'nama_poli' => 'required|string|max:255|unique:polis,name,' . $poli->id,
            'deskripsi' => 'nullable|string',
        ]);

        // PERBAIKAN 2: Mapping Manual
        // Kita tidak bisa pakai $poli->update($request->all());
        // Kita harus pasangkan input form ke kolom database secara manual
        $poli->update([
            'name' => $request->nama_poli,        // Input 'nama_poli' masuk ke kolom 'name'
            'description' => $request->deskripsi, // Input 'deskripsi' masuk ke kolom 'description'
        ]);

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil diperbarui.');
    }

    /**
     * Menghapus Poli (Delete Poli).
     */
    public function destroy(Poli $poli)
    {
        $poli->delete();
        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil dihapus.');
    }
}