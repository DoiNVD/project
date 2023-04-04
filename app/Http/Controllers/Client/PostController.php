<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\category_post;
use App\Models\Post;
use App\Models\product;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public  function index(){
        $cats=category_post::where('status',1)->get();
        foreach($cats as $cat){
            $list_cat[]=$cat->id;
        }
        $posts=Post::where('status',1)->whereIn('cat_id',$list_cat)->orderBy('created_at','desc')->paginate(6);
        $seller_products=Product::where('num_sold','>',0)->orderBy('num_sold','desc')->where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        $banners = Banner::where('status', 1)->orderBy('created_at', 'desc')->limit(1)->get();
        return view('client.post.index', compact('posts','seller_products','banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($slug){
        $post=Post::where('slug',$slug)->first();
        $seller_products=Product::where('num_sold','>',0)->orderBy('num_sold','desc')->where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        $banners = Banner::where('status', 1)->orderBy('created_at', 'desc')->limit(5)->get();
        return view('client.post.detail',compact('post','seller_products','banners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
