@extends('admin.layouts.app')
@section('title')
Danh sách Permission
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
            <h5 class="m-0 ">Danh sách quyền</h5>
            <a href="{{url('admin/permission/add')}}" class="btn btn-success">Thêm mới</a>

        </div>
        <div class="card-body">
            <form action="{{url('admin/user/action')}}" method="post">
                @csrf
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên quyền</th>
                            <th scope="col">Mô tả quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                            $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($page - 1) * $num_per_page + 1;
                        @endphp
                    @foreach ($permissions as $permission)
                            <tr>
                                <th scope="row">{{ $start++ }}</th>
                                <td class="title">
                                    @if ($permission->parent_id != 0)
                                        ---- {{ $permission->name }}
                                    @else
                                        {{ $permission->name }}
                                    @endif
                                </td>
                                <td>{{ $permission->display_name }}</td>
                                <td>{{ $permission->created_at }}</td>
                                <td>
                                    @can('edit-permission')
                                        <a href="{{ route('permission.edit', $permission->id) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('delete-permission')
                                        <a href="{{ route('permission.delete', $permission->id) }}"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            <div style="float: right;">
                {{$permissions->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
@endsection