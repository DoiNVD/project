@extends('admin.layouts.app')
@section('title')
Danh sách User
@endsection
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if(Session::has('status'))
        <div class="alert alert-success">
            {{ Session::get('status') }}
            @php
            Session::forget('status');
            @endphp
        </div>
        @endif
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            @can('add-user')
            <a href="{{url('admin/user/add')}}" class="btn btn-success">Thêm mới</a>
            @endcan

        </div>
        <div class="card-body">
            <div class="analytic d-flex justify-content-between">
                <div class="status">
                    <a href="{{request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{$count[0]}})</span></a>
                    <a href="{{request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{$count[1]}})</span></a>
                </div>
                <div class="form-search form-inline">
                    <form action="#" method="GET">
                        <input type="text" class="form-control form-search" name="search" value="{{request()->input('search')}}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{url('admin/user/action')}}" method="post">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option value="NULL">Chọn</option>
                        @foreach ($list_act as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($users->total()>0)

                        @php
                        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $num_per_page + 1;
                        @endphp

                        @foreach($users as $user)

                        <tr>
                            <td>
                                @if (Auth::id() != $user->id)
                                <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                                @endif
                            </td>
                            <td scope="row">{{$start++}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @foreach ($roles as $role)
                                @if ($role->user_id === $user->id)
                                <span class="badge badge-primary text-center mr-2">{{ $role->name }}</span>
                                @endif
                                @endforeach
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                @can('edit-user')
                                <a href="{{url('admin/user/edit/'.$user->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @endcan

                                @if (Auth::id() != $user->id)
                                @if (isset($_GET['status']) && $_GET['status'] === 'trash')
                                @can('delete-user')
                                <a href="{{url('admin/user/delete/'.$user->id)}}?status=trash" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endcan
                                @else
                                @can('delete-user')
                                <a href="{{url('admin/user/delete/'.$user->id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endcan
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="bg-white">Không tìm thấy bản ghi</td>
                        </tr>

                        @endif
                    </tbody>
                </table>
            </form>
            <div>
                {{$users->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
@endsection