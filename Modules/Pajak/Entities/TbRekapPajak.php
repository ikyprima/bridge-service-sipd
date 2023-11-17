<?php

namespace Modules\Pajak\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TbRekapPajak extends Model
{
    use HasFactory;
    protected $table = 'tb_rekap_pajak';
    public $timestamps = true;
    protected $fillable = [
        "id_skpd",
        "tanggal_dokumen",
        "bulan_dokumen",
        "jenis",
        "tbp_kwt" ,
        "nilai_belanja",
        "uraian_belanja",
        "dpp",
        "kode_akun",
        "jenis_pajak",
        "jumlah_pajak",
        "npwp",
        "kode_skpd",
        "nama_skpd",
        "ntpn",
        "tahun",
        "ver",
        "jenis_sipd",
        "jenis_pajak_sipd",
        "kode_rekening",
        "kategori_sipd",
        "visible"
    ];
   
    protected static function newFactory()
    {
        return \Modules\Pajak\Database\factories\TbRekapPajakFactory::new();
    }
}
