<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_images;
use Illuminate\Support\Facades\Validator;
use App\Traits\storageImageTrait;

class ProductController extends Controller
{

    use storageImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách sản phẩm",
            'data' => $products
        ];
        return response()->json($arr, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'slug' => 'required',
            'num' => 'required',
            'cat_id' => 'required',
            'product_detail' => 'required',
            'product_desc' => 'required',
            'status' => 'required',

        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 422);
        }

        $featured = $request->featured;
        if (isset($featured)) {
            $featured = $request->featured;
        } else {
            $featured = 0;
        }
        $discount = $request->discount;
        if (isset($discount)) {
            $discount = $request->discount;
        } else {
            $discount = 0;
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'price' => $request->price,
            'code' => '#' . substr(time(), strlen(time()) - 9, strlen(time())),
            'num' => $request->num,
            'discount' => $discount,
            'product_thumb' => 'Null.jpg',
            'product_detail' => $request->product_detail,
            'product_desc' => $request->product_desc,
            'cat_id' => "21",
            'user_id' => 21,
            'product_featured' => $featured,
            'status' => $request->status,
            'price_real' => $request->price * (1 - ($request->discount / 100))
        ]);


        $arr = [
            'status' => true,
            'message' => "Sản phẩm đã lưu thành công",
            'data' => $product,
        ];
        return response()->json($arr, 201);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($id)
    {
        $Product = product::find($id);
        $arr = [
            'status' => true,
            'message' => "Danh sách sản phẩm",
            'data' => $Product
        ];
        return response()->json($arr, 200);
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

        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'slug' => 'required',
            'num' => 'required',
            // 'product_thumb' => 'required|max:30000|mimes:jpg,JPG,png,PNG,GIF,gif',
            // 'product_image' => 'required',
            // 'product_image.*' => 'image|mimes:jpeg,png,jpg,JPG,gif,GIF,PNG,svg|max:30000',
            'cat_parent' => 'required',
            'product_detail' => 'required',
            'product_desc' => 'required',

        ]);
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Lỗi kiểm tra dữ liệu',
                'data' => $validator->errors()
            ];
            return response()->json($arr, 422);
        }
        $product_thumb = "1668675609-samsung-galaxy-z-flip-3-kem-2-org-copy.jpg";
        // $product_thumb = $this->storageTraitUpload($request, 'product_thumb', 'product');
        if ($product_thumb === null) {
            $product_thumb = $request->product_thumb_old;
        }
        $product = Product::withTrashed()->find($id);
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
            'user_id' => 21,
            'product_featured' =>  $request->featured,
            'status' => $request->status,
            'price_real' => $request->price * (1 - ($request->discount / 100))
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
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm cập nhật thành công',
            'data' => $product
        ];
        return response()->json($arr, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
       
        $product = Product::withTrashed()->find($id);
        if(!$product){
            return response()->json([  'message' => 'Không tìm thấy sản phẩm'], 404);
        }
        $product->forceDelete();
        $arr = [
            'status' => true,
            'message' => 'Sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
