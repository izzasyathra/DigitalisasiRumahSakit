<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua poli dari database
        $polis = Poli::all();

        // Kirim ke view
        return view('home', compact('polis'));
    }
}
