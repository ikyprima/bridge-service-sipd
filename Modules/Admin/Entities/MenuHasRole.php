<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHasRole extends Model
{
    use HasFactory;
    protected $table= "menu_has_roles";
    protected $fillable = ["id_menu","id_roles","ket"];
    public function menuItem(){
        return $this->hasOne('Modules\Admin\Entities\MenuItem','id','id_menu');
    }
}
