<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBannerRequest;
use App\Models\Banner;
use App\Models\User;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBannerController extends Controller
{

    use StorageImageTrait;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'banner']);
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
        //
        $num_per_page = 5;
        $banners = Banner::paginate($num_per_page);
        $users = User::all();
        return view('admin.banner.list', compact('banners', 'users', 'num_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.banner.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddBannerRequest $request)
    {
        //
        $image_path = $this->storageTraitUpload($request, 'image_path', 'banner');
        Banner::create([
            'title' => $request->title,
            'image_path' => $image_path,
            'description' => $request->description,
            'link' => $request->link,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/banner/list')->with('status', 'Thêm banner thành công');
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
        $banner = Banner::find($id);
        return view('admin.banner.edit', compact('banner'));
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
        $request->validate([
            'title' => 'required',
            'image_path' => 'max:10000|mimes:jpg,JPG,png,PNG,GIF,gif', //a required, max 10000kb
            'description' => 'required',
            'link' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg, png hoặc gif',
        ], [
            'title' => 'Tiêu đề ',
            'image_path'=>'Ảnh',
            'description' => 'mô tả ngắn',
            'link' => 'link',   
        ]);
        $image_path = $this->storageTraitUpload($request, 'image_path', 'banner');
        if($image_path == null){
            $image_path=$request->image_old;
        }
        $banner=Banner::find($id);

        $banner->update([
            'title'=>$request->title,
            'image_path' => $image_path,
            'description'=>$request->description,
            'link'=>$request->link,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/banner/list')->with('status', 'Cập nhật Banner thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Banner::find($id)->delete();
        return response()->json(['data'=>'removed'],200);
    }
}
