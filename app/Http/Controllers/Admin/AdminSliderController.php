<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddSliderRequest;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\storageImageTrait;

class AdminSliderController extends Controller
{
    use storageImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()   
    {
        $this->middleware(function ($request, $next){
            session(['module_active'=>'slider']);
            return $next($request);
        });
       
    }

    public function index()
    {
        //
        $num_per_page = 5;
        $sliders = Slider::paginate($num_per_page);
        $users = User::all();
        return view('admin.slider.list', compact('sliders','users','num_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.slider.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddSliderRequest $request)
    {
        //
        $image_path = $this->storageTraitUpload($request, 'image_path', 'slider');
        Slider::create([
            'title'=>$request->title,
            'image_path' => $image_path,
            'description'=>$request->description,
            'link'=>$request->link,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/slider/list')->with('status', 'Thêm slider thành công');
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
        $slider=Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $request->validate([
            'title' => 'required',
            'image_path' => 'max:10000|mimes:jpg,JPG,png,PNG,GIF,gif', //a required, max 10000kb
            'description' => 'required',
            'link' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg,png hoặc gif',
        ], [
            'title' => 'Tiêu đề trang',
            'image_path'=>'Ảnh',
            'description' => 'mô tả ngắn',
            'link' => 'link',   
        ]);

        $image_path = $this->storageTraitUpload($request, 'image_path', 'slider');
        if($image_path == null){
            $image_path=$request->image_old;
        }
        $slider=Slider::find($id);

        $slider->update([
            'title'=>$request->title,
            'image_path' => $image_path,
            'description'=>$request->description,
            'link'=>$request->link,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/slider/list')->with('status', 'Cập nhật slider thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        Slider::find($id)->delete();
        return response()->json(['data'=>'removed'],200);
    }
}
