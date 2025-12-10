<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    // 1. Tampilkan Daftar Obat
    public function index()
    {
        $medicines = Medicine::paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    // 2. Tampilkan Form Tambah
    public function create()
    {
        return view('admin.medicines.create');
    }

    // 3. Simpan Obat Baru (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:medicines,nama',
            'type'  => 'required',
            'stock' => 'required|integer',
            'price' => 'required|numeric', // Validasi Harga
        ]);

        Medicine::create([
            'nama'      => $request->name,
            'deskripsi' => $request->description,
            'tipe'      => $request->type, 
            'stok'      => $request->stock,
            'harga'     => $request->price, // Simpan Harga
        ]);

        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit (INI YANG TADI ERROR/HILANG)
    public function edit($id)
    {
        // Cari obat berdasarkan ID
        $medicine = Medicine::find($id);
        
        // Pilihan untuk dropdown (pastikan Value sama dengan yang di database)
        $types = ['Tablet', 'Sirup', 'Kapsul', 'Salep', 'Suntik', 'Lainnya'];

        return view('admin.medicines.edit', compact('medicine', 'types'));
    }

    // 5. Update Obat (UPDATE)
    public function update(Request $request, $id)
    {
        $medicine = Medicine::find($id);

        if (!$medicine) {
            return redirect()->back()->with('error', 'Data obat tidak ditemukan!');
        }

        $request->validate([
            'name'  => 'required',
            'type'  => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric', // Validasi Harga
        ]);

        // Update Data
        $medicine->nama      = $request->name;
        $medicine->tipe      = $request->type;
        $medicine->stok      = $request->stock;
        $medicine->harga     = $request->price; // Update Harga
        $medicine->deskripsi = $request->description;
        
        $medicine->save();

        return redirect()->route('admin.medicines.index')->with('success', 'Berhasil update obat!');
    }
    
    // 6. Hapus Obat
    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        if($medicine){
            $medicine->delete();
        }
        return redirect()->route('admin.medicines.index')->with('success', 'Obat berhasil dihapus!');
    }
}