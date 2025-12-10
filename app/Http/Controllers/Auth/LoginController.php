<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Logika Login (POST)
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Login ke Database
        if (Auth::attempt($credentials, $request->remember)) {
            
            $request->session()->regenerate();
            $user = Auth::user(); 
            
            // ADMIN
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); 
            } 
            
            // DOKTER
            elseif ($user->role === 'dokter') {
                return redirect()->intended('/doctor/dashboard');
            }
            
            elseif ($user->role === 'pasien'){
                return redirect()->intended('/patient/dashboard'); 
            }
            
            return redirect()->intended('/'); 
        }
        
        // 3. Jika Gagal
        return back()->withErrors([
            'email' => 'Kombinasi Email dan Password tidak ditemukan.',
        ])->onlyInput('email');
    }
    
    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); 
    }
}