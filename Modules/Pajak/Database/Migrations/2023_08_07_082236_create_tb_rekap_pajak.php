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
       

        Schema::create('tb_rekap_pajak', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_skpd');
            $table->date('tanggal_dokumen');
            $table->string('bulan_dokumen');
            $table->string('jenis');
            $table->string('tbp_kwt');
            $table->double('nilai_belanja',20,2);
            $table->text('uraian_belanja');
            $table->double('dpp',20,2);
            $table->integer('kode_akun')->nullable();
            $table->string('jenis_pajak')->nullable();
            $table->double('jumlah_pajak',20,2)->nullable();
            $table->string('npwp')->nullable();
            $table->string('kode_skpd');
            $table->string('nama_skpd');
            $table->string('ntpn')->nullable();
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
        Schema::dropIfExists('');
    }
};
