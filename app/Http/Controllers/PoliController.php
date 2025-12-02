<?php
namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index(){ $polis = Poli::all(); return view('public.polis', compact('polis')); }
    public function create(){ return view('admin.polis.create'); }
    public function store(Request $r){ $r->validate(['name'=>'required|unique:polis']); Poli::create($r->only('name','description','icon')); return redirect()->route('polis.index')->with('success','Poli dibuat'); }
    public function edit(Poli $poli){ return view('admin.polis.edit', compact('poli')); }
    public function update(Request $r, Poli $poli){ $r->validate(['name'=>'required|unique:polis,name,'.$poli->id]); $poli->update($r->only('name','description','icon')); return back()->with('success','Diupdate'); }
    public function destroy(Poli $poli){ $poli->delete(); return back()->with('success','Dihapus'); }

    public function home(){ $polis = Poli::with('doctors')->get(); return view('home', compact('polis')); }
}
