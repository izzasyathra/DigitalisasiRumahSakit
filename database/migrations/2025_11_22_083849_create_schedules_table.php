<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id') 
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('day');
            $table->time('start_time');
            $table->integer('duration_minutes')->default(30);

            $table->timestamps();
        });
    }

        public function down()
        {
            Schema::dropIfExists('schedules');
        }
    };
