<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\category_product;
use App\Models\Menu;
use App\Models\product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(session('order')!=NULL){
            session()->forget('order');
        }
        $sliders=Slider::where('status',1)->orderBy('created_at','desc')->limit(10)->get();
        $featured_products=product::where('product_featured',1)->where('status',1)->orderBy('created_at','desc')->limit(10)->get();
        $discount_products=Product::where('discount','>',0)->where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        $newest_products=Product::orderBy('created_at','desc')->where('status',1)->limit(8)->get();
        $seller_products=Product::where('num_sold','>',0)->orderBy('num_sold','desc')->where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        $banners=Banner::where('status',1)->orderBy('created_at','desc')->limit(6)->get();
        $listCatParents=category_product::where('parent_id',0)->where('status',1)->get();
        return view('client.home.index',compact('sliders','featured_products','discount_products','newest_products','seller_products','banners','listCatParents'));
    }
}
