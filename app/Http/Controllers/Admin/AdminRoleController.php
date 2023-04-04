<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()   
    {
        $this->middleware(function ($request, $next){
            session(['module_active'=>'role']);
            return $next($request);
        });
       
    }
    public function index()
    {
        //
        $num_per_page=5;
        $roles=Role::paginate($num_per_page);
        return view('admin.role.list',compact('roles','num_per_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissionParent=Permission::where('parent_id',0)->get();
        return view('admin.role.add',compact('permissionParent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoleRequest $request)
    {
        //
        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        $role->permission()->attach($request->permission_id);
        return redirect('admin/role/list')->with('status', 'Thêm vai trò mới thành công.');
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
        $role=Role::find($id);
        $permissionParent=Permission::where('parent_id',0)->get();
        $permissions=$role->permission;
        return view('admin.role.edit',compact('role','permissions','permissionParent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddRoleRequest $request, $id)
    {
        //
        $role = Role::find($id);
        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);
        $role->permission()->sync($request->permission_id);
        return redirect('admin/role/list')->with('status', 'Cập nhật vai trò thành công');
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
        Role::find($id)->delete();
        return redirect('admin/role/list')->with('status','Bạn đã xóa vai trò thành công');
    }
}
