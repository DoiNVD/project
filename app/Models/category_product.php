<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_product extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function cat_child(){
        return $this->hasMany(Category_product::class,'parent_id');
    }
    public  function product(){
        return $this->hasMany(Product::class,'cat_id');
    }
}
