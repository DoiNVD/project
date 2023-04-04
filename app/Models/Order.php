<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $table='orders';
    protected $guarded=[];
    function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    function product(){
        return $this->belongsToMany(Product::class,'detail_orders','order_code','product_id','order_code');
    }
}
