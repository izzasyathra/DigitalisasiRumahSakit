<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Pasien (User)
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade'); 
            
            // Relasi ke Dokter (User)
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade'); 
            
            // Relasi ke Jadwal (Slot waktu praktik yang dipilih)
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('restrict');
            
            $table->date('tanggal_booking');
            $table->text('keluhan_singkat');
            
            // Status Janji Temu: Pending, Approved, Rejected, Selesai
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Selesai'])->default('Pending');
            
            $table->text('alasan_penolakan')->nullable(); // Jika status Rejected
            
            // Unique constraint: Satu pasien tidak boleh booking slot jadwal yang sama pada hari yang sama
            $table->unique(['patient_id', 'schedule_id', 'tanggal_booking']); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};