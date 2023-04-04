<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'menu']);
            return $next($request);
        });
    }
    public function index()
    {
        //

        $users = User::all();
        $menus = Menu::All();
        $listMenu = multi_level_menu($menus); // tạo multi-level menu
        // Chuyển đổi $listMenu sang chuỗi JSON
        $jsonMenu = json_encode($listMenu);
        // Chuyển đổi chuỗi JSON sang mảng
        $arrayMenu = json_decode($jsonMenu, true);
        $perPage = 5;
        $pageStart = request('page', 1);
        //array_chunk tạo một mảng mới gồm các nhóm phần tử của mảng ban đâu có số phần tử bbằng với $perpage
        $arrayMenuChunked = array_chunk($arrayMenu, $perPage);  
        $paginatedArray = new LengthAwarePaginator(
            $arrayMenuChunked[$pageStart - 1] ?? [],
            count($arrayMenu),
            $perPage,
            $pageStart,
            ['path' => url()->current()]
        );

        return view('admin.menu.list', compact('menus', 'users', 'paginatedArray','listMenu',  'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $menus = Menu::all();
        $listMenu = multi_level_menu($menus);
        return view('admin.menu.add', compact('listMenu'));
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
        $request->validate([
            'name' => 'required',
            'link' => 'required',
            'slug' => 'required',
            'position' => 'required'
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'name' => 'Tên menu',
            'link' => 'Link',
            'slug' => 'Slug',
            'position' => 'Position'
        ]);
        Menu::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'link' => $request->link,
            'position' => $request->position,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
            'status' => $request->status
        ]);
        return redirect('admin/menu/list')->with('status', 'Thêm menu thành công');
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
        $menu = Menu::find($id);
        $menus = Menu::all();
        $listCat = multi_level_menu($menus);
        return view('admin.menu.edit', compact('menu', 'listCat'));
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
            'name' => 'required',
            'link' => 'required',
            'slug' => 'required',
            'position' => 'required'
        ], [
            'required' => ':attribute không được để trống',
        ], [
            'name' => 'Tên menu',
            'link' => 'Link',
            'slug' => 'Slug',
            'position' => 'vị trí'
        ]);
        $menu = Menu::find($id);
        $menu->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'link' => $request->link,
            'position' => $request->position,
            'status' => $request->status
        ]);
        return redirect('admin/menu/list')->with('status', 'Cập nhật menu thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $menu = Menu::find($id);
        if (count($menu->cat_child) > 0) {
            return redirect('admin/menu/list')->with('status', 'Bạn phải xóa danh mục con của danh mục này trước');
        } else {
            $menu->delete();
            return redirect('admin/menu/list')->with('status', 'Bạn đã xóa menu  thành công');
    }
}
}