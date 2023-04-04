<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category_Post;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\storageImageTrait;


class AdminPostController extends Controller
{
    use storageImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    public function index()
    {
        $num_per_page = 5;
        $search = isset($_GET['search']) ? $_GET['search'] : 'no_search';
        $status = !empty($_GET['status']) ? $_GET['status'] : '';
        $list_act = array();
        if ($status == 'public') {
            $title="DANH SÁCH BÀI VIẾT ĐÃ ĐĂNG";
            if ($search == 'no_search') {
                $posts = Post::where('status', '1')->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $posts = Post::where('status', '1')->orderBy('created_at','desc')->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
            $list_act = array(
                'pending' => 'Chờ duyệt',
                'trash' => 'Thùng rác'
            );
        } else if ($status == 'pending') {
            $title="DANH SÁCH BÀI VIẾT CHỜ DUYỆT";
            if ($search == 'no_search') {
                $posts = Post::where('status', '0')->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $posts = Post::where('status', '0')->orderBy('created_at','desc')->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
            $list_act = array(
                'public' => 'Công khai',
                'trash' => 'Thùng rác'
            );
        } else if ($status == 'trash') {
            $title="DANH SÁCH BÀI VIẾT VÔ HIỆU HÓA";
            $list_act = array(
                'restore' => 'Khôi phục',
                'delete_pernament' => 'Xóa vĩnh viễn'
            );
            if ($search == 'no_search') {
                $posts = Post::onlyTrashed()->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $posts = Post::onlyTrashed()->orderBy('created_at','desc')->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
        } else {
            $title="DANH SÁCH BÀI VIẾT";
            $list_act = array(
                'public' => 'Công khai',
                'pending' => 'Chờ duyệt',
                'trash' => 'Thùng rác'
            );
            if ($search == 'no_search') {
                $posts = Post::withTrashed()->orderBy('created_at','desc')->paginate($num_per_page);
            } else {
                $posts = Post::withTrashed()->orderBy('created_at','desc')->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
        }
        $post_public = Post::where('status', 1)->get();
        $post_pending = Post::where('status', 0)->get();
        $post_trash = Post::onlyTrashed()->get();
        $post_all = Post::withTrashed()->get();
        $users = User::all();
        $listCat = Category_post::all();
        return view('admin.post.list', compact('posts', 'users', 'post_public', 'post_pending', 'post_trash', 'post_all', 'list_act','title','listCat','num_per_page'));
    }


    public function index_cat()
    {
        $listCat = Category_post::all();
        $users = User::all();
        $list_cat_mutiple_menu = multi_level_menu($listCat);
        return view('admin.post.category.list', compact('list_cat_mutiple_menu', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listCat = Category_post::all();
        $list_cat_mutiple_menu = multi_level_menu($listCat);
        return view('admin.post.add', compact('list_cat_mutiple_menu'));
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
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required',
            'featured_image' => 'required|max:10000|mimes:jpg,JPG,png,PNG,GIF,gif', //a required, max 10000kb
            'cat_parent' => 'required',
        ], [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg,png hoặc gif',
        ], [
            'title' => 'Tiêu đề bài viết',
            'content' => 'Nội dung bài viết',
            'slug' => 'Slug',
            'featured_image' => 'Ảnh đại diện',
            'cat_parent' => "Danh mục cho bài viết"
        ]);
        $featured_image_path = $this->storageTraitUpload($request, 'featured_image', 'post');

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'featured_image_path' => $featured_image_path,
            'cat_id' => $request->cat_parent,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/post/list')->with('status', 'Thêm bài viết thành công');
    }

    public function store_cat(Request $request)
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

        Category_post::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'user_id' => Auth::id(),
            'parent_id' => $request->cat_parent,
            'status' => $request->status
        ]);
        return redirect('admin/post/category/list')->with('status', 'Thêm danh mục bài viết mới thành công');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public  function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == "public") {
                Post::onlyTrashed()->whereIn('id', $list_check)->restore();
                Post::whereIn('id', $list_check)->update(
                    ['status' => 1]
                );
                return redirect('admin/post/list')->with('status', 'Bạn đã thay đổi trạng thái công khai thành công');
            } else if ($act == "pending") {
                Post::onlyTrashed()->whereIn('id', $list_check)->restore();
                Post::whereIn('id', $list_check)->update(
                    ['status' => 0]
                );
                return redirect('admin/post/list')->with('status', 'Bạn đã thay đổi trạng thái chờ duyệt thành công');
            } else if ($act == "trash") {
                Post::destroy($list_check);
                return redirect('admin/post/list')->with('status', 'Bạn đã chuyển vào thùng rác thành công');
            } else if ($act == "restore") {
                Post::onlyTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục bài viết thành công');
            } else if($act== 'delete_pernament') {
                Post::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/post/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn bài viết thành công');
            }else {
                return back()->with('status', 'Bạn cần chọn hành động để thực hiện');
            }
        } else {
            return redirect('admin/post/list')->with('status', 'Bạn cần chọn phần tử để thực hiện');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listCat = Category_post::all();
        $list_cat_mutiple_menu = multi_level_menu($listCat);
        $post = Post::withTrashed()->where('id',$id)->first();
        return view('admin.post.edit', compact('post','list_cat_mutiple_menu'));
    }


    public function edit_cat($id)
    {
          // $listCat = Category_post::all();
          $cat = Category_post::find($id);
          // $list_cat_mutiple_menu = multi_level_menu($listCat);
          // return view('admin.posts.category.edit', compact('cat', 'list_cat_mutiple_menu'));
          return response()->json(['data'=>$cat],200); // 200 là mã lỗi
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'slug' => 'required',
            'featured_image' => 'max:10000|mimes:jpg,JPG,png,PNG,GIF,gif', //a required, max 10000kb
            'cat_parent'=>'required',
        ], [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg,png hoặc gif',
        ], [
            'title' => 'Tiêu đề bài viết',
            'content' => 'Nội dung bài viết',
            'slug' => 'Slug',
            'featured_image'=>'Ảnh đại diện',
            'cat_parent'=>"Bạn phải chọn danh mục cho bài viết"
        ]);
        $featured_image_path = $this->storageTraitUpload($request, 'featured_image', 'post');
        if($featured_image_path===null){
            $featured_image_path=$request->featured_image_old;
        }
        $post = Post::withTrashed()->find($id);
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'featured_image_path' => $featured_image_path,
            'cat_id' => $request->cat_parent,
            'status' => $request->status
        ]);
        return redirect('admin/post/list')->with('status', 'Cập nhật bài viết thành công');
    }

    public function update_cat_ajax(Request $request, $id)
    {
        $cat = Category_post::find($id);
        $cat->update([
           'name' => $request->name,
             'slug' => $request->slug,
            'status' => $request->status
        ]);
        $listCat = Category_post::all();
        $list_cat_mutiple_menu = multi_level_menu($listCat);
        foreach($list_cat_mutiple_menu as $catItem){
            if($cat->id==$catItem->id){
                $cat=$catItem;
            }
        }
              // return redirect('admin/post/category/list')->with('status', 'Cập nhật danh mục bài viết thành công');
        return response()->json(['data'=>$cat],200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post=Post::onlyTrashed()->get();
        if ($post->contains('id', $id)) {
            $post = Post::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect('admin/post/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn bài viết thành công');
        } else {
            $post = Post::find($id)->delete();
            return redirect('admin/post/list')->with('status', 'Bạn đã xóa bài viết thành công');
        }
    }
    public function delete_cat_ajax($id)
    {
        $cat = Category_post::find($id);
        if (count($cat->cat_child) > 0) {
            // return redirect('admin/post/category/list')->with('status', 'Bạn phải xóa danh mục con của danh mục này trước');
            return response()->json(['data'=>'error','message'=>"Bạn phải xóa danh mục con của danh mục này trước"],200);
        }
        else{
            $cat->delete();
            // return redirect('admin/post/category/list')->with('status', 'Xóa danh mục bài viết thành công');
            return response()->json(['data'=>'removed'],200);
        }

    }
}
