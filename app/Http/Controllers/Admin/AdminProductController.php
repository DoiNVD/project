<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category_product;
use App\Models\Product;
use App\Models\User;
use App\Models\Product_images;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Traits\storageImageTrait;

class AdminProductController extends Controller
{

    use storageImageTrait;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $num_per_page = 5;
        $search = isset($_GET['search']) ? $_GET['search'] : 'no_search';
        $status = !empty($_GET['status']) ? $_GET['status'] : '';
        $list_act = array();
        if ($status == 'public') {
            $title = "DANH SÁCH SẢN PHẨM ĐÃ ĐĂNG";
            if ($search == 'no_search') {
                $products = Product::where('status', '1')->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $products = Product::where('status', '1')->orderBy('created_at','desc')->where('name', 'like', "%{$search}%")->paginate($num_per_page);
            }
            $list_act = array(
                'pending' => 'Chờ duyệt',
                'trash' => 'Thùng rác'
            );
        } else if ($status == 'pending') {
            $title = "DANH SÁCH SẢN PHẨM CHỜ DUYỆT";
            if ($search == 'no_search') {
                $products = Product::where('status', '0')->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $products = Product::where('status', '0')->orderBy('created_at','desc')->where('name', 'like', "%{$search}%")->paginate($num_per_page);
            }
            $list_act = array(
                'public' => 'Công khai',
                'trash' => 'Thùng rác'
            );
        } else if ($status == 'trash') {
            $title = "DANH SÁCH SẢN PHẨM VÔ HIỆU HÓA";
            $list_act = array(
                'restore' => 'Khôi phục',
                'delete_pernament' => 'Xóa vĩnh viễn'
            );
            if ($search == 'no_search') {
                $products = Product::onlyTrashed()->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $products = Product::onlyTrashed()->orderBy('created_at','desc')->where('name', 'like', "%{$search}%")->paginate($num_per_page);
            }
        } else {
            $title = "DANH SÁCH SẢN PHẨM";
            $list_act = array(
                'public' => 'Công khai',
                'pending' => 'Chờ duyệt',
                'trash' => 'Thùng rác'
            );
            if ($search == 'no_search') {
                $products = Product::withTrashed()->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $products = Product::withTrashed()->orderBy('created_at','desc')->where('name', 'like', "%{$search}%")->paginate($num_per_page);
            }
        }
        $product_public = Product::where('status', 1)->get();
        $product_pending = Product::where('status', 0)->get();
        $product_trash = Product::onlyTrashed()->get();
        $product_all = Product::withTrashed()->get();
        $users = User::all();
        $listCat = Category_product::all();
        return view('admin.product.list', compact('products', 'users', 'product_public', 'product_pending', 'product_trash', 'product_all', 'list_act', 'title', 'listCat','num_per_page'));

    }
    public function index_cat()
    {
       
        $listCatProduct = Category_product::all();
        $users = User::all();
        $list_cat_mutiple_menu = multi_level_menu($listCatProduct);
        //  show_array($list_cat_mutiple_menu );
        // // Chuyển đổi $listMenu sang chuỗi JSON
        // $jsonMenu = json_encode($list_cat_mutiple_menu);
        // // Chuyển đổi chuỗi JSON sang mảng
        // $arrayMenu = json_decode($jsonMenu, true);
        // $perPage = 5;
        // $pageStart = request('page', 1);
        // //array_chunk tạo một mảng mới gồm các nhóm phần tử của mảng ban đâu có số phần tử bbằng với $perpage
        // $arrayMenuChunked = array_chunk($arrayMenu, $perPage);  
        // $paginatedArray = new LengthAwarePaginator(
        //     $arrayMenuChunked[$pageStart - 1] ?? [],
        //     count($arrayMenu),
        //     $perPage,
        //     $pageStart,
        //     ['path' => url()->current()]
        // );
        return view('admin.product.category.list', compact('list_cat_mutiple_menu', 'users'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listCatProduct = Category_product::all();
        $list_cat_mutiple_menu = multi_level_menu($listCatProduct);
        return view('admin.product.add', compact('list_cat_mutiple_menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'slug' => 'required',
            'num' => 'required',
            'product_thumb' => 'required|max:30000|mimes:jpg,JPG,png,PNG,GIF,gif',
            'product_image' => 'required',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,JPG,gif,GIF,PNG,svg|max:30000',
            'cat_parent' => 'required',
            'product_detail' => 'required',
            'product_desc' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg,png hoặc gif',
        ], [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm',
            'slug' => 'Slug',
            'num' => 'Số lượng',
            'product_thumb' => 'Ảnh đại diện',
            'product_image' => 'Ảnh mô tả',
            'product_detail' => 'Chi tiết sản phẩm',
            'product_desc' => 'Mô tả sản phẩm',
            'cat_parent' => "Danh mục cho bài viết"
        ]);
        $product_thumb = $this->storageTraitUpload($request, 'product_thumb', 'product');
        $featured= $request->featured ;
        if ($featured) {
            $featured= $request->featured ;
        }else{
            $featured = 0;
        }
        $discount=$request->discount;
        if ($discount) {
            $discount=$request->discount;
        }else{
            $discount = 0;
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'code' => '#'.substr(time(),strlen(time())-9,strlen(time())),
            'num' => $request->num,
            'discount' => $discount,
            'product_thumb' => $product_thumb,
            'product_detail' => $request->product_detail,
            'product_desc' => $request->product_desc,
            'cat_id' => $request->cat_parent,
            'user_id' => Auth::id(),
            'product_featured' => $featured,
            'status' => $request->status,
            'price_real'=>$request->price*(1-($request->discount/100))
        ]);

        if ($request->hasFile('product_image')) {
            foreach ($request->product_image as $fileItem) {
                $image_path = $this->storageTraitUploadMultiple($fileItem, 'product');
                Product_images::create([
                    'image_path' => $image_path,
                    'product_id' => $product->id
                ]);
            }
        }
        return redirect('admin/product/list')->with('status', 'Thêm sản phẩm thành công');  
    }
    public  function store_cat(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'name' => 'Tên danh mục',
            'slug' => 'Slug',
        ]);
        Category_product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'user_id' => Auth::id(),
            'parent_id' => $request->cat_parent,
            'status' => $request->status
        ]);
        return redirect()->back()->with('status', 'Thêm danh mục sản phẩm mới thành công');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::withTrashed()->where('id',$id)->first();
        $listCatProduct = Category_product::all();
        $list_cat_mutiple_menu = multi_level_menu($listCatProduct);
        return view('admin.product.edit', compact('list_cat_mutiple_menu','product'));
    }
    public function edit_cat(Product $product, $id)
    {
        $listCatProduct = Category_product::all();
        $catProduct = Category_product::find($id);
        $list_cat_mutiple_menu = multi_level_menu($listCatProduct);
        return view('admin.product.category.edit', compact('catProduct', 'list_cat_mutiple_menu'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'slug' => 'required',
            'num' => 'required',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,JPG,gif,GIF,PNG,svg|max:30000',
            'cat_parent' => 'required',
            'product_detail' => 'required',
            'product_desc' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg,png hoặc gif',
        ], [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm',
            'slug' => 'Slug',
            'num' => 'Số lượng',
            'product_image' => 'Ảnh mô tả',
            'product_detail' => 'Chi tiết sản phẩm',
            'product_desc' => 'Mô tả sản phẩm',
            'cat_parent' => "Danh mục cho bài viết"
        ]);
  
        $product_thumb = $this->storageTraitUpload($request, 'product_thumb', 'product');
        // $featured= $request->featured ;
        // if ($featured) {
        //     $featured= $request->featured ;
        // }else{
        //     $featured = 0;
        // }
        // $discount=$request->discount;
        // if ($discount) {
        //     $discount=$request->discount;
        // }else{
        //     $discount = 0;
        // }
        if($product_thumb===null){
            $product_thumb=$request->product_thumb_old;
        }
        $product=Product::withTrashed()->find($id);
        $product->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'num' => $request->num,
            'discount' => $request->discount,
            'product_thumb' => $product_thumb,
            'product_detail' => $request->product_detail,
            'product_desc' => $request->product_desc,
            'cat_id' => $request->cat_parent,
            'user_id' => Auth::id(),
            'product_featured' =>  $request->featured,
            'status' => $request->status,
            'price_real'=>$request->price*(1-($request->discount/100))
        ]);

        if ($request->hasFile('product_image')) {
            foreach ($request->product_image as $fileItem) {
                $image_path = $this->storageTraitUploadMultiple($fileItem, 'product');
                Product_images::create([
                    'image_path' => $image_path,
                    'product_id' => $product->id
                ]);
            }
        }
        return redirect('admin/product/list')->with('status', 'Cập nhật sản phẩm thành công');
    }

    public function update_cat(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'name' => 'Tên danh mục',
            'slug' => 'Slug',
        ]);
        $catProduct = Category_product::find($id);
        $catProduct->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status
        ]);
        return redirect('admin/product/category/list')->with('status', 'Cập nhật danh mục sản phẩm thành công');
    }

public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == "public") {
                Product::onlyTrashed()->whereIn('id', $list_check)->restore();
                Product::whereIn('id', $list_check)->update(
                    ['status' => 1]
                );
                return redirect('admin/product/list')->with('status', 'Bạn đã thay đổi trạng thái công khai thành công');
            } else if ($act == "pending") {
                Product::onlyTrashed()->whereIn('id', $list_check)->restore();
                Product::whereIn('id', $list_check)->update(
                    ['status' => 0]
                );
                return redirect('admin/product/list')->with('status', 'Bạn đã thay đổi trạng thái chờ duyệt thành công');
            } else if ($act == "trash") {
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status', 'Bạn đã chuyển vào thùng rác thành công');
            } else if ($act == "restore") {
                Product::onlyTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục sản phẩm thành công');
            } else if($act == "delete_pernament"){
                Product::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/product/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn sản phẩm thành công');
            }else{
                return back()->with('status', 'Bạn cần chọn hành động để thực hiện');
            }
        } else {
            return redirect('admin/product/list')->with('status', 'Bạn cần chọn phần tử để thực hiện');
        }
    }
    public  function delete_image_child($id)
    {
        Product_images::find($id)->delete();
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $product=Product::onlyTrashed()->get();
        if ($product->contains('id', $id)) {
            $product = Product::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect('admin/product/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn sản phẩm thành công');
        } else {
            $product = Product::find($id)->delete();
            return redirect('admin/product/list')->with('status', 'Bạn đã xóa sản phẩm thành công');
        }
    }
    public function delete_cat($id)
    {
        $catProduct = Category_product::find($id);
        if (count($catProduct->cat_child) > 0) {
            return redirect('admin/product/category/list')->with('status', 'Bạn phải xóa danh mục con của danh mục này trước');
        }
        $catProduct->delete();
        return redirect('admin/product/category/list')->with('status', 'Xóa danh mục sản phẩm thành công');
    }
}
