<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Dokter\ScheduleController;
use App\Http\Controllers\Dokter\MedicalRecordController as DokterMedicalRecordController;
use App\Http\Controllers\Pasien\AppointmentController;
use App\Http\Controllers\Pasien\MedicalRecordController as PasienMedicalRecordController;
use App\Http\Controllers\AppointmentManagementController;

// Public routes (Guest/Tamu)
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/guest', [PublicController::class, 'index'])->name('guest.index');
Route::get('/polis', [PublicController::class, 'polis'])->name('public.polis');
Route::get('/polis/{id}', [PublicController::class, 'poliDetail'])->name('public.polis.show');
Route::get('/dokters', [PublicController::class, 'dokters'])->name('public.dokters');
Route::get('/dokters/{id}', [PublicController::class, 'dokterDetail'])->name('public.dokters.show');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // User Management
        Route::resource('users', UserController::class);
        
        // Poli Management
        Route::resource('polis', PoliController::class);
        
        // Medicine Management
        Route::resource('medicines', MedicineController::class);
        
        // All appointments view
        Route::get('appointments', [AppointmentManagementController::class, 'allAppointments'])
            ->name('appointments.all');

            
    });

    // Dokter routes
    Route::middleware('role:dokter')->prefix('dokter')->name('dokter.')->group(function () {
        // Schedule Management
        Route::resource('schedules', ScheduleController::class);
        
        // Medical Records
        Route::get('medical-records/queue', [DokterMedicalRecordController::class, 'queue'])
            ->name('medical-records.queue');
        Route::resource('medical-records', DokterMedicalRecordController::class);
    });

    // Pasien routes
    Route::middleware('role:pasien')->prefix('pasien')->name('pasien.')->group(function () {
        // Appointment booking flow
        Route::get('appointments/select-poli', [AppointmentController::class, 'selectPoli'])
            ->name('appointments.select-poli');
        Route::get('appointments/polis/{poliId}/dokters', [AppointmentController::class, 'selectDokter'])
            ->name('appointments.select-dokter');
        Route::get('appointments/create', [AppointmentController::class, 'create'])
            ->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])
            ->name('appointments.store');
        Route::get('appointments', [AppointmentController::class, 'index'])
            ->name('appointments.index');
        Route::get('appointments/{id}', [AppointmentController::class, 'show'])
            ->name('appointments.show');
        Route::post('appointments/{id}/cancel', [AppointmentController::class, 'cancel'])
            ->name('appointments.cancel');
        
        // Medical Records (read only)
        Route::get('medical-records', [PasienMedicalRecordController::class, 'index'])
            ->name('medical-records.index');
        Route::get('medical-records/{id}', [PasienMedicalRecordController::class, 'show'])
            ->name('medical-records.show');
    });

    // Appointment management (Admin & Dokter)
    Route::middleware('role:admin,dokter')->prefix('appointments')->name('appointments.')->group(function () {
        Route::get('pending', [AppointmentManagementController::class, 'index'])
            ->name('pending');
        Route::post('{id}/approve', [AppointmentManagementController::class, 'approve'])
            ->name('approve');
        Route::get('{id}/reject', [AppointmentManagementController::class, 'showRejectForm'])
            ->name('reject.form');
        Route::post('{id}/reject', [AppointmentManagementController::class, 'reject'])
            ->name('reject');
    });
});