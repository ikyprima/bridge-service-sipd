<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = "menu_items";
    protected $with = ["children"];
    protected $fillable = ["id_parent","is_parent","id_menu","title","url","name_route","icon"];
    protected $hidden = [
        'updated_at','deleted_at','created_at','id_menu'
    ];

    public function children(){
        return $this->hasMany(Self::class, "id_parent", "id");
    }
    public function parent(){
        return $this->belongsTo(Self::class, "id_parent", "id")->with('parent')->without('children');
        // return $this->belongsTo("App\Model\mRuangan", "parent_id", "id")->with('parent');
    }


    public function menu(){
        return $this->hasOne('Modules\Admin\Entities\Menu','id','id_menu');
    }
}
