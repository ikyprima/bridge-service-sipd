<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuteHasPermission extends Model
{
    use HasFactory;
    protected $table = "rute_has_permission";

    public function permission(){
        return $this->hasOne('Modules\Admin\Entities\Permission','id','id_permission');
    }

}
