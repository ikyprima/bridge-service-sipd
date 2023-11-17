<?php

namespace Modules\Pajak\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TbUploadTemplatePajak extends Model
{
    use HasFactory;
    protected $table = "tb_upload_template_pajak";
    protected $fillable = ['id_skpd','path_file','tahun','updated_at'];
    protected static function newFactory()
    {
        return \Modules\Pajak\Database\factories\TbUploadTemplatePajakFactory::new();
    }
}
