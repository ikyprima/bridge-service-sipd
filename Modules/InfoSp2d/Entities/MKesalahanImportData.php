<?php

namespace Modules\InfoSp2d\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MKesalahanImportData extends Model
{
    use HasFactory;
    

        protected $table = 'm_kesalahan_import_data';
        protected $fillable = ['id_jenis_data_source','halaman_gagal','nama_kesalahan_error','url'];
    protected static function newFactory()
    {
        return \Modules\InfoSp2d\Database\factories\MKesalahanImportDataFactory::new();
    }
}
