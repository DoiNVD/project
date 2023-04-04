<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_post extends Model
{
    use HasFactory;
    protected $guarded=[];
    function cat_child(){
        return $this->hasMany(Category_post::class,'parent_id');
    }
}
