<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Fungsi untuk memproses pendaftaran
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Buat User Baru di Database
        $user = User::create([
            // Jika di database kolomnya 'username', ganti 'name' di kiri jadi 'username'
            'name' => $request->name, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien', // <--- PENTING: Set otomatis jadi pasien
        ]);

        // 3. Login otomatis setelah daftar
        Auth::login($user);

        // 4. Arahkan ke Dashboard Pasien
        return redirect()->route('patient.dashboard');
    }
}