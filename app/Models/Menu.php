<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table ='menus';
    protected $guarded=[];
 public function cat_child(){
        return $this->hasMany(Menu::class,'parent_id')->orderBy('position');
    }
}
