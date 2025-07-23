<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanRuangrapatTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('peminjaman_ruangrapat', function (Blueprint $table) {
    //         $table->id();
    //         $table->foreignId('id_user');
    //         $table->foreignId('id_ruangrapat');
    //         $table->string('peminjam');
    //         $table->integer('jumlah_peserta');
    //         $table->date('tanggal');
    //         $table->time('jam_mulai');
    //         $table->time('jam_selesai');
    //         $table->string('keperluan');
    //         $table->boolean('status')->default(true);
    //         $table->timestamps();
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('peminjaman_ruangrapat_tabel');
    // }
}