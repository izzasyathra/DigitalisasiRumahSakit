<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
{
    if (!Auth::check()) {
        return redirect('/login');
    }

    // buat array roles (misal: "admin|dokter")
    $allowedRoles = explode('|', $roles);

    if (!in_array(Auth::user()->role, $allowedRoles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}
}
