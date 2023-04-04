<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPageRequest;
use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()   
    {
        $this->middleware(function ($request, $next){
            session(['module_active'=>'page']);
            return $next($request);
        });
       
    }


    public function index()
    {
        //
        $num_per_page = 5;
        $search = isset($_GET['search']) ? $_GET['search'] : 'no_search';
        $status = !empty($_GET['status']) ? $_GET['status'] : '';
        $list_act = array();
        if ($status == 'public') {
            $title="DANH SÁCH TRANG ĐÃ ĐĂNG";
            if ($search == 'no_search') {
                $pages = Page::where('status', '1')->paginate($num_per_page);
            } else {
                $pages = Page::where('status', '1')->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
            $list_act = array(
                'pending' => 'Chờ duyệt',
                'trash' => 'Thùng rác'
            );
        } else if ($status == 'pending') {
            $title="DANH SÁCH TRANG CHỜ DUYỆT";
            if ($search == 'no_search') {
                $pages = Page::where('status', '0')->paginate($num_per_page);
            } else {
                $pages = Page::where('status', '0')->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
            $list_act = array(
                'public' => 'Công khai',
                'trash' => 'Thùng rác'
            );
        } else if ($status == 'trash') {
            $title="DANH SÁCH TRANG VÔ HIỆU HÓA";
            $list_act = array(
                'restore' => 'Khôi phục',
                'delete_pernament' => 'Xóa vĩnh viễn'
            );
            if ($search == 'no_search') {
                $pages = Page::onlyTrashed()->paginate($num_per_page);
            } else {
                $pages = Page::onlyTrashed()->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
        } else {
            $title="DANH SÁCH TRANG";
            $list_act = array(
                'public' => 'Công khai',
                'pending' => 'Chờ duyệt',
                'trash' => 'Thùng rác'
            );
            if ($search == 'no_search') {
                $pages = Page::withTrashed()->paginate($num_per_page);
            } else {
                $pages = Page::withTrashed()->where('title', 'like', "%{$search}%")->paginate($num_per_page);
            }
        }
        $page_public = Page::where('status', 1)->get();
        $page_pending = Page::where('status', 0)->get();
        $page_trash = Page::onlyTrashed()->get();
        $page_all = Page::withTrashed()->get();
        $users = User::all();
        return view('admin.page.list', compact('pages', 'users', 'page_public', 'page_pending', 'page_trash', 'page_all', 'list_act','title', 'num_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.page.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPageRequest $request)
    {
        //
        // $slug= Str::slug($request->slug,'-');
        Page::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/page/list')->with('status', 'Thêm trang mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::withTrashed()->where('id',$id)->first();
        return view('admin.page.edit', compact('page'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(AddPageRequest $request, $id)
    {
         $page = Page::withoutTrashed()->find($id);
        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'user_id' => Auth::id(),
            'status' => $request->status,
        ]);
        return redirect('admin/page/list')->with('status', 'Cập nhật trang thành công');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            $act = $request->input('act');
            if ($act == "public") {
                Page::onlyTrashed()->whereIn('id', $list_check)->restore();
                Page::whereIn('id', $list_check)->update(
                    ['status' => 1]
                );
                return redirect('admin/page/list')->with('status', 'Bạn đã thay đổi trạng thái công khai thành công');
            } else if ($act == "pending") {
                Page::onlyTrashed()->whereIn('id', $list_check)->restore();
                Page::whereIn('id', $list_check)->update(
                    ['status' => 0]
                );
                return redirect('admin/page/list')->with('status', 'Bạn đã thay đổi trạng thái chờ duyệt thành công');
            } else if ($act == "trash") {
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Bạn đã chuyển vào thùng rác thành công');
            } else if ($act == "restore") {
                Page::onlyTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục trang thành công');
            } else if ($act == "delete_pernament") {
                Page::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/page/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn trang thành công');
            } else{
                return back()->with('status', 'Bạn cần chọn hành động để thực hiên.');
            }
        } else {
            return redirect('admin/page/list')->with('status', 'Bạn cần chọn phần tử để thực hiện');
        }
    }

    public function delete($id)
    {
        //
        $page=Page::onlyTrashed()->get();
        if ($page->contains('id', $id)) {
            $page = Page::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect('admin/page/list?status=trash')->with('status', 'Bạn đã xóa vĩnh viễn trang thành công');
        } else {
            $page = Page::find($id)->delete();
            return redirect('admin/page/list')->with('status', 'Bạn đã xóa trang thành công');
        }
    }
}
