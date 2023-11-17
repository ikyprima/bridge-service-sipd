<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_halaman_import', function (Blueprint $table) {
            $table->id();
            $table->integer('halaman_terakhir'); //halaman import terakhir
            $table->year('tahun'); 
            $table->integer('id_jenis_data_source'); //1 = ds sp2d yang terverifikasi
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
        Schema::dropIfExists('tb_halaman_import');
    }
};
