<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $rolesArray = explode('|', $roles); 
        $user = Auth::user();

        if (!in_array($user->role, $rolesArray)) { 
            return redirect('/')->with('error', 'Akses ditolak.');
        }

        return $next($request);if (!in_array(strtolower($user->role), array_map('strtolower', $rolesArray))) { 
        
        abort(403, 'Akses ditolak. Anda tidak memiliki peran yang sesuai.'); 
    }
    }
}