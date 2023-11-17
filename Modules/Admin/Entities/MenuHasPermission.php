<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHasPermission extends Model
{

    use HasFactory;
    protected $table= 'menu_has_permissions';
    
    public function menuItem(){
        return $this->hasOne('Modules\Admin\Entities\MenuItem','id','id_menu');
    }
}
