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
        Schema::create('m_kesalahan_import_data', function (Blueprint $table) {
            $table->id();
            $table->integer('id_jenis_data_source'); //1 = ds sp2d yang terverifikasi
            $table->integer('halaman_gagal'); //halaman yang gagal import
            $table->text('nama_kesalahan_error');
            $table->string('url');
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
        Schema::dropIfExists('m_kesalahan_import_data');
    }
};
