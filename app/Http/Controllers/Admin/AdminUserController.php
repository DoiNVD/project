<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use TheSeer\Tokenizer\Exception;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // 
        $num_per_page = 5;
        $status = $request->input('status');
        $list_act = [
            'delete' => 'Vô hiệu hóa',
        ];
        if ($status == 'trash') {
            $list_act = [
                'restore' => 'Khôi Phục',
                'forceDelete' => 'Xóa vĩnh viễn',
            ];
            $users = User::onlyTrashed()->orderBy('created_at','desc')->paginate($num_per_page);
        } else {
            $search = "";
            if ($request->input('search')) {
                $search = $request->input('search');
            }
            $users = User::where('name', 'LIKE', "%{$search}%")->orderBy('created_at','desc')->paginate($num_per_page);
        }

        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];
        $roles = DB::table('user_role')
            ->join('roles', 'user_role.role_id', '=', 'roles.id')
            ->get();
        // dd($users);
        return view('admin.user.list', compact('users', 'count', 'list_act', 'roles','num_per_page' ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = \App\Models\role::all();
        return view('admin.user.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->roles()->attach($request->roles);
            DB::commit();
            return redirect('admin/user/list')->with('success', 'Đã thêm thành viên thành công.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('message:' . $e->getMessage() . 'Line' . $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        //
      
        // if ($list_check) {
        //     foreach ($list_check as $k => $id) {
        //         if (Auth::id() == $id) {
        //             unset($list_check[$k]); //Loại bỏ thao tác lên chính bản thân mình
        //         }
        //     }
        $list_check = $request->input('list_check');
        if (!empty($list_check)) {
            
            $act = $request->input('act');
            if($act == "NULL"){
                return back()->with('status', 'Bạn cần chọn hành động để thực hiên.');
            }
            if ($act == "delete") {
                User::destroy($list_check);    //xóa bản ghi có Id muốn xóa
                return redirect('admin/user/list')->with('status', 'Đã xóa thành công.');
            }
            if ($act == "restore") {
                User::onlyTrashed($list_check)->whereIn('id', $list_check)->restore(); //Điều kiện Id thuộc tập hợp
                return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công.');
            }
            if ($act == "forceDelete") {
                return  $list_check;
                User::onlyTrashed($list_check)->whereIn('id', $list_check) ->forceDelete();
                return redirect('admin/user/list')->with('status', 'Bạn đã xóa vĩnh viễn user thành công.');
            }
         
        } else {
            return back()->with('status', 'Bạn cần chọn phần tử để thực hiên.');
        }
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
        $user = User::find($id);
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        //
        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]);
            $user->roles()->sync($request->roles);
            DB::commit();
            return redirect('admin/user/list')->with('status', 'Cập nhật thành viên thành công.');
        } catch (Exception $e) {
            DB::rollBack();
        }
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

        if (Auth::id() != $id) {
            $status = !empty($_GET['status']) ? $_GET['status'] : '';
            if ($status === 'trash') {
                $user = User::onlyTrashed()->where('id', $id)->forceDelete();
                return  redirect()->back()->with('status', 'Bạn đã xóa vĩnh viễn thành viên thành công');
            } else {
                $user = User::find($id)->delete();
                return redirect('admin/user/list')->with('status', 'Bạn đã xóa thành viên thành công');
            }
        } else {
            return redirect()->back()->with('status', __(' BẠn không thể tự xóa mình ra khỏi hệ thống.'));
        }
    }
}
