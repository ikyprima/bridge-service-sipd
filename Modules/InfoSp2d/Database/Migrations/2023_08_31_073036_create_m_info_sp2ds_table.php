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

    //  {
    //     "idSpm": 56471,
    //     "nomorSp2d": "08.00/04.0/000033/LS/2.16.2.20.2.21.01.0000/P.05/8/2023",
    //     "tanggalSp2d": "2023-08-29",
    //     "tahunSp2d": 2023,
    //     "idSubUnit": null,
    //     "keteranganSp2d": "Belanja Internet Dedicated 5000 MB untuk Bulan Juli 2023 berdasarkan Surat Perjanjian Kerja Nomor 020/121/SP/DISKOMINFOTIK/2023 tgl 01 Mei 2023",
    //     "idUser": 189120,
    //     "jenisSp2d": "LS",
    //     "nilaiSp2d": "620000000",
    //     "jenisLs": "Bendahara",
    //     "isPergeseran": 0,
    //     "isPelimpahan": 0,
    //     "created_at": "2023-08-28 10:30:56",
    //     "updated_at": "2023-08-29 14:52:23",
    //     "isTbpLs": null,
    //     "idSkpd": 2618,
    //     "isDraft": 0,
    //     "idSp2d": 39511,
    //     "idDaerah": 180,
    //     "verifikasiSp2d": 0,
    //     "tanggalVerifikasi": null,
    //     "idSkpdTujuan": 2618,
    //     "kunciRekening": 1,
    //     "isBku": 0,
    //     "bulan_gaji": null,
    //     "tahun_gaji": null,
    //     "jenis_gaji": null,
    //     "is_bku_skpd": 0,
    //     "id_jadwal": 100,
    //     "id_tahap": 30,
    //     "status_tahap": "pergeseran",
    //     "kode_tahap": "P.05",
    //     "status_aklap": null,
    //     "nomor_jurnal": null,
    //     "jurnal_id": null,
    //     "metode": null,
    //     "bulan_tpp": 0,
    //     "tahun_tpp": null,
    //     "nomor_rekening_pembayar": "71000106009346",
    //     "bank_rekening_pembayar": "Bank Nagari",
    //     "is_rekening_pembayar": 0,
    //     "id_user_penandatangan": 188639,
    //     "id_kontrak": null,
    //     "nomor_kontrak": null,
    //     "id_created_by": 190180,
    //     "nomorSpm": "08.00/03.0/000040/LS/2.16.2.20.2.21.01.0000/P.05/8/2023",
    //     "tanggalSpm": "2023-08-28",
    //     "tahunSpm": 2023,
    //     "keteranganSpm": "Belanja Internet Dedicated 5000 MB untuk Bulan Juli 2023 berdasarkan Surat Perjanjian Kerja Nomor 020/121/SP/DISKOMINFOTIK/2023 tgl 01 Mei 2023",
    //     "verifikasiSpm": 1,
    //     "tanggalVerifikasiSpm": "2023-08-29",
    //     "jenisSpm": "LS",
    //     "nilaiSpm": "620000000",
    //     "keteranganVerifikasiSpm": null,
    //     "isOtorisasi": 0,
    //     "tanggalOtorisasi": null,
    //     "is_sptjm": 1,
    //     "namaSkpd": "DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK",
    //     "kodeSkpd": "2.16.2.20.2.21.01.0000",
    //     "is_bpk": 0,
    //     "pergeseran_status": 1,
    //     "is_nilai_sp2d_valid": true
    // }


    public function up()
    {
        Schema::create('tb_info_sp2d', function (Blueprint $table) {
            $table->id();
            $table->string('kodeSkpd');
            $table->string('namaSkpd');
            $table->year('tahunSp2d');
            $table->bigInteger('idSp2d');
            $table->string('noSp2d');
            $table->text('keteranganSp2d');
            $table->date('tanggalSp2d');
            $table->string('jenisSp2d')->nullable();
            $table->double('nilaiSp2d',20,2);
            $table->char('verifikasiSp2d', 1)->default('0');
            $table->boolean('is_nilai_sp2d_valid');
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
        Schema::dropIfExists('tb_info_sp2d');
    }
};
