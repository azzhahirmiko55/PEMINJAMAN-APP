<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPeminjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_peminjam');
            $table->unsignedBigInteger('id_kendaraan')->nullable();
            $table->unsignedBigInteger('id_ruangan')->nullable();
            $table->unsignedBigInteger('id_verifikator')->nullable();
            $table->enum('tipe_peminjaman', ['kendaraan', 'ruangan']);
            $table->date('tanggal');
            $table->dateTime('jam_mulai');
            $table->dateTime('jam_selesai');
            $table->text('keperluan')->nullable();
            $table->text('driver')->nullable();
            $table->text('jumlah_peserta')->nullable();
            $table->integer('status')->nullable();
            $table->boolean('active_st')->default(1);
            $table->text('verifikator_catatan')->nullable();
            $table->dateTime('verifikator_tgl')->nullable();
            $table->boolean('pengembalian_st')->default(0);
            $table->dateTime('pengembalian_tgl')->nullable();
            $table->unsignedBigInteger('pengembalian_pegawai_id')->nullable();
            $table->text('pengembalian_catatan')->nullable();
            // $table->text('pengembalian_bukti')->nullable();
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
        Schema::dropIfExists('tb_peminjaman');
    }
}
