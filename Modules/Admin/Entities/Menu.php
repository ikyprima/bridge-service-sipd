<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table= 'menu';
    protected $fillable = ['name','order'];
    protected $hidden = [
        'updated_at','deleted_at','created_at'
    ];

    public function menuItem(){
        return $this->hasMany('Modules\Admin\Entities\MenuItem','id_menu','id');
    }
}
