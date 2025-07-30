<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('id_pegawai');
            $table->string('username')->unique();
            $table->text('password');
            $table->longText('profile_picture')->nullable();
            $table->integer('role')->default(4);
            // 0 => Admin
            // 1 => Kasubag
            // 2 => Staff TU
            // 3 => Satpam
            // 4 => Pegawai BPN
            $table->boolean('active_st')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_user');
    }
}