<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\category_product;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $cat = category_product::where('slug', $slug)->first();
        if (empty($cat)) {
            return abort('404');
        }
        $listCat = $cat->cat_child;

        $listId = array();
        $listId[] = $cat->id;

        foreach ($listCat as $catItem) {
            $listId[] = $catItem->id;
        }
        $listCatParents = Category_product::where('parent_id', 0)->where('status', 1)->get();
      
        $q = product::query();
        $listProducts = $q->where('status', 1)->whereIn('cat_id', $listId)->get();

        // sap xep
        if (!isset($_GET['filter']) && !isset($_GET['filter_price'])) {
            session()->forget('filter');
            session()->forget('filter_price');
        };
        if (session('filter') == null) {
            session(['filter' => 'default']);
        }
        $filter = isset($_GET['filter']) ? $_GET['filter'] : session('filter');
        session(['filter' => $filter]);
        $filter = session('filter');
        if ($filter == "asc") {
            $q->orderBy('name', 'asc');
        } else if ($filter == "desc") {
            $q->orderBy('name', 'desc');
        } else if ($filter == "price_min") {
            $q->orderBy('price_real', 'desc');
        } else if ($filter == "price_max") {
            $q->orderBy('price_real');
        } else {
            session()->forget('filter');
        }


        // sap xep theo gia
        if (session('filter_price') == null) {
            session(['filter_price' => '']);
        }
        $filter_price = isset($_GET['filter_price']) ? $_GET['filter_price'] : session('filter_price');
        session(['filter_price' => $filter_price]);
        $filter_price = session('filter_price');
        if (session('filter_price') == "price_1") {
            $q->whereBetween('price_real', [0, 500000]);
        } else if (session('filter_price')  == "price_2") {
            $q->whereBetween('price_real', [500000, 1000000]);
        } else if (session('filter_price')  == "price_3") {
            $q->whereBetween('price_real', [1000000, 5000000]);
        } else if (session('filter_price')  == "price_4") {
            $q->whereBetween('price_real', [5000000, 10000000]);
        } else if (session('filter_price')  == "price_5") {
            $q->whereBetween('price_real', [10000000, 15000000]);
        } else if (session('filter_price')  == "price_6") {
            $q->whereBetween('price_real', [15000000, 20000000]);
        } else if (session('filter_price')  == "price_7") {
            $q->where('price_real', '>', 20000000);
        } else {
            session()->forget('filter_price');
        }
        $listProducts = $q->paginate(16);
        $seller_products=Product::where('num_sold','>',0)->orderBy('num_sold','desc')->where('status',1)->orderBy('created_at','desc')->limit(10)->get();
        return view('client.product.index', compact('cat', 'listCatParents', 'listProducts',  'filter', 'filter_price', 'seller_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $banners = Banner::where('status', 1)->orderBy('created_at', 'desc')->limit(2)->get();
       // $products_same_cat sẽ trở thành một mảng các sản phẩm cùng danh mục cha với sản phẩm đang được xét đến (được lấy từ thuộc tính "product" của đối tượng "cat_parent").
        $products_same_cat = $product->cat_parent->product;
        // show_array($products_same_cat);
        foreach ($products_same_cat as $key => $item) {
            if ($item->slug == $slug) {
                unset($products_same_cat[$key]);
                break;
            }
        }
        $seller_products=Product::where('num_sold','>',0)->orderBy('num_sold','desc')->where('status',1)->orderBy('created_at','desc')->limit(8)->get();
        $listCatParents = Category_product::where('parent_id', 0)->where('status', 1)->get();
        return view('client.product.detail', compact('product', 'banners', 'products_same_cat', 'listCatParents', 'seller_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;
        if (empty($search)) {
            return redirect()->back();
        } else {
            // $seller_products = Product::orderBy('num_sold', 'desc')->where('status', 1)->orderBy('created_at', 'desc')->limit(8)->get();
            $banners = Banner::where('status', 1)->orderBy('created_at', 'desc')->limit(2)->get();
            $product_searched = Product::where('name', 'like', '%' . $search . '%')->where('status', 1)->paginate(16);
            $listCatParents = Category_product::where('parent_id', 0)->where('status', 1)->get();
            return view('client.product.productSearch', compact('product_searched', 'banners', 'listCatParents', 'search'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function result_search(){
        $key_search=$_GET['key_search'];
        $products=Product::where('name','like',"%".$key_search."%")->where('status',1)->limit(8)->get();
        return response()->json(['data'=>$products],200); // 200 là mã lỗi
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
