<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangrapatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ruang_rapat', function (Blueprint $table) {
            $table->id('id_ruangrapat');
            $table->text('nama_ruangan');
            $table->text('warna_ruangan');
            $table->boolean('tersedia_st')->default(1);
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
        Schema::dropIfExists('tb_ruang_rapat');
    }
}