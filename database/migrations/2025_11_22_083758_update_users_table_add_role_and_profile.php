<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableAddRoleAndProfile extends Migration
{

public function up()
{
    Schema::table('users', function (Blueprint $table) {
        
        if (!Schema::hasColumn('users', 'role')) {
            $table->enum('role', ['admin', 'dokter', 'pasien'])->notNull()->default('pasien')->after('password');
        }

        if (!Schema::hasColumn('users', 'avatar')) {
            $table->string('avatar')->nullable()->after('remember_token');
        }
    });

    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'poli_id')) {

            $table->unsignedBigInteger('poli_id')->nullable()->after('role');
        }
        
    });

    
}
    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        // Hapus foreign key poli_id dulu jika sudah ada
        // if (Schema::hasColumn('users', 'poli_id')) {
        //    $table->dropForeign(['poli_id']);
        // }
        
        if (Schema::hasColumn('users', 'role')) {
            $table->dropColumn('role');
        }
        if (Schema::hasColumn('users', 'poli_id')) {
            $table->dropColumn('poli_id');
        }
        if (Schema::hasColumn('users', 'avatar')) {
            $table->dropColumn('avatar');
        }
    });
}
}
