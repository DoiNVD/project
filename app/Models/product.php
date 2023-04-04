<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =[];
   public function image_child(){
        return $this->hasMany(Product_images::class,'product_id');
    }
    public function cat_parent(){
        return $this->belongsTo(Category_product::class,'cat_id');
    }



}
