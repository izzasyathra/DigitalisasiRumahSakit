<?php
namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(){ $medicines = Medicine::all(); return view('admin.medicines.index', compact('medicines')); }
    public function create(){ return view('admin.medicines.create'); }
    public function store(Request $r){ $r->validate(['name'=>'required']); Medicine::create($r->only('name','description','type','stock','expired_at','image')); return redirect()->route('admin.medicines.index')->with('success','Obat dibuat'); }
}
