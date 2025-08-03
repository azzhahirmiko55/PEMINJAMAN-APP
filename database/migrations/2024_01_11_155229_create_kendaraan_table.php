<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKendaraanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kendaraan', function (Blueprint $table) {
            $table->id('id_kendaraan');
            $table->string('no_plat')->unique();
            $table->enum('jenis_kendaraan', ['Roda-2', 'Roda-4']);
            $table->text('warna_kendaraan');
            $table->text('keterangan');
            // $table->boolean('tersedia_st')->default(1);
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
        Schema::dropIfExists('tb_kendaraan');
    }
}