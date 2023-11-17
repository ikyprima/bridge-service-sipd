<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
class Role extends SpatieRole
{
    use HasFactory;

    // protected $appends = ['menurole'];

    public function getMenuroleAttribute()
        {
            return $this->hasMany('Modules\Admin\Entities\MenuHasRole', 'id_roles', 'id')->with('menuItem.menu')->get();
        }
}
