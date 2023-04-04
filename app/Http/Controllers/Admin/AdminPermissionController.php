<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()   
    {
        $this->middleware(function ($request, $next){
            session(['module_active'=>'permission']);
            return $next($request);
        });
       
    }

    
    public function index()
    {
        //
        $num_per_page = 10;
        $permissions = Permission::paginate($num_per_page);
        return view('admin.permission.list', compact('permissions', 'num_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissionParent = Permission::where('parent_id', 0)->get();
        return view('admin.permission.add', compact('permissionParent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPermissionRequest $request)
    {
        //
        $Permission = Permission::create([
            'name' =>  ucfirst($request->name),
            'display_name' =>  ucfirst($request->display_name),
            'key_code' => $request->key_code,
            'parent_id' => $request->parent_id,
        ]);
        return redirect('admin/permission/list')->with('status', 'Thêm quyền mới thành công.');
     
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
        $permission = Permission::find($id);
        $permissionParent = Permission::where('parent_id', 0)->get();
        return view('admin.permission.edit', compact( 'permission', 'permissionParent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddPermissionRequest $request, $id)
    {
        //
        $permission = Permission::find($id);
        $permission->update([
            'name' =>  ucfirst($request->name),
            'display_name' =>  ucfirst($request->display_name),
            'key_code'=>$request->key_code,
            'parent_id'=>$request->permission_parent
        ]);
        return redirect('admin/permission/list')->with('status', 'Cập nhật quyền thành công');
    
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
        $permission=Permission::find($id);
        if($permission->parent_id==0 && count($permission->permissionChild)>0){
            return redirect('admin/permission/list')->with('status', 'Bạn phải xóa các quyền con trước khi xóa module cha');
        }else{
            $permission->delete();
        }
        return redirect('admin/permission/list')->with('status', 'Bạn đã xóa quyền thành công');
    }
}
