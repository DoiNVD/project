@extends('admin.layouts.app')
@section('title')
Danh sáchRole
@endsection
@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center mb-4">
                <h5 class="m-0 ">Danh sách vai trò</h5>
                @can('add-role')
                    <a href="{{ route('role.add') }}" class="btn btn-success">Thêm mới</a>
                @endcan
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên vai trò</th>
                            <th scope="col">Mô tả vai trò</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                            $start = ($page - 1) * $num_per_page + 1;
                        @endphp
                        @foreach ($roles as $role)
                            <tr>
                                <th scope="row">{{ $start++ }}</th>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>
                                    @can('edit-role')
                                        <a href="{{url('admin/role/edit/'.$role->id)}}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('delete-role')
                                        <a href="{{url('admin/role/delete/'.$role->id)}}"
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
                <div>
                {{$roles->links('pagination::bootstrap-4')}}
            </div>
            </div>
        </div>
    </div>
@endsection
