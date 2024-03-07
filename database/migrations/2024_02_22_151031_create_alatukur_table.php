<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatukurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alatukur', function (Blueprint $table) {
            $table->id();
            $table->string('plat');
            $table->enum('jenis', ['GPS-Receiver', 'Alat-Ukur']);
            $table->text('nup');
            $table->text('keterangan');
            $table->text('warna');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('alatukur');
    }
}
