<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
class Permission extends SpatiePermission
{
    use HasFactory;
    /**
     * Get the menu associated with the Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // protected $appends = ['menu'];

    public function getMenuAttribute()
        {
        
            // return $this->hasOne('Modules\Admin\Entities\MenuItem', 'id', 'id_menu_item')->with('menu')->first();
            return $this->hasMany('Modules\Admin\Entities\MenuHasPermission', 'id_permissions', 'id')->with('menuItem.menu')->get();
        
        }
    public function rute(){
        return $this->hasOne('Modules\Admin\Entities\RuteHasPermission','id_permission','id');
    }
}
