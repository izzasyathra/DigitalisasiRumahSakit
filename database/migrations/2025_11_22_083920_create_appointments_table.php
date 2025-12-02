<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->date('booking_date');
            $table->text('complaint');
            $table->enum('status',['Pending','Approved','Rejected','Selesai'])->default('Pending');
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
