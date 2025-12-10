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
            'nama_poli' => 'required|string|max:255|unique:polis,name',
            'deskripsi' => 'nullable|string',
        ]);

        Poli::create([
            'name'        => $request->nama_poli, 
            'description' => $request->deskripsi, 
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
           
            'nama_poli' => 'required|string|max:255|unique:polis,name,' . $poli->id,
            'deskripsi' => 'nullable|string',
        ]);

        $poli->update([
            'name' => $request->nama_poli,       
            'description' => $request->deskripsi, 
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