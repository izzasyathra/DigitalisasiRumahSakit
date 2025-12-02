<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Admin, Dokter, Pasien, Guest
            $table->timestamps();
        });

        // optionally seed basic roles
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
