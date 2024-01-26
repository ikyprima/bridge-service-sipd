<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instance extends Model
{
    use HasFactory;

    protected $table = 'tb_skpd';
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\InstanceFactory::new();
    }
}
