<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PoliController;

// ================= HOME ==================
Route::get('/', function () {
    return view('welcome');
});

// ================= AUTH (BREEZE) =========
require __DIR__.'/auth.php';

// ================= ADMIN ==================
Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
    });


