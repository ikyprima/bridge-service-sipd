<?php

namespace Modules\InfoSp2d\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MInfoSp2d extends Model
{
    use HasFactory;
    protected $table = 'tb_info_sp2d';
    protected $fillable = ['kodeSkpd','namaSkpd','tahunSp2d','idSp2d','noSp2d','keteranganSp2d','tanggalSp2d','jenisSp2d','nilaiSp2d','verifikasiSp2d','is_nilai_sp2d_valid','nomor_halaman'];
    
    protected static function newFactory()
    {
        return \Modules\InfoSp2d\Database\factories\MInfoSp2dFactory::new();
    }
}
