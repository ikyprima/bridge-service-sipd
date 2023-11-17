<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_rekap_pajak', function (Blueprint $table) {
            //
            $table->string('jenis_sipd')->nullable(); //jenis dokumune sipd (LS,GU,LS GAJI)
            $table->string('jenis_pajak_sipd')->nullable(); //jenis potongan pajak sipd
            $table->string('kode_rekening')->nullable(); //kode rekening sipd
            $table->string('kategori_sipd')->nullable(); //kategori (pajak, potongan)
            $table->char('visible', 1)->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_rekap_pajak', function (Blueprint $table) {
            //
            $table->dropColumn('jenis_sipd');
            $table->dropColumn('jenis_pajak_sipd');
            $table->dropColumn('kode_rekening');
            $table->dropColumn('kategori_sipd');
            $table->dropColumn('visible');

        });
    }
};
