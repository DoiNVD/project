<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =[];
    function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    function cat_parent(){
        return $this->belongsTo(Category_post::class,'cat_id');
    }
}
