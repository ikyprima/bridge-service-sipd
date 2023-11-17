<?php

namespace Modules\InfoSp2d\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MhalamanImport extends Model
{

    use HasFactory;
    protected $table = 'tb_halaman_import';
    protected $fillable = ['halaman_terakhir','tahun','id_jenis_data_source'];
    
    protected static function newFactory()
    {
        return \Modules\InfoSp2d\Database\factories\MhalamanImportFactory::new();
    }
}
