<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel users (dokter)
        $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
        
        $table->string('day'); // Senin, Selasa, dst
        $table->time('start_time');
        $table->time('end_time'); // Akan otomatis dihitung (+30 menit)
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};