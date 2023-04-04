@extends('admin.layouts.app')
@section('title')
Danh sách Trang
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
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">{{ $title }}</h5>
            @can('add-page')
            <a href="{{url('admin/page/add/')}}" class="btn btn-success">Thêm mới</a>
            @endcan
        </div>
        <div class="card-body">
            <div class="analytic d-flex justify-content-between">
                <div class="status">
                    <a href="{{url('admin/page/list/')}}" class="text-primary">Tất cả<span class="text-muted">({{ count($page_all) }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary">Đã
                        đăng<span class="text-muted">({{ count($page_public) }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ count($page_pending) }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng
                        rác<span class="text-muted">({{ count($page_trash) }})</span></a>
                </div>

                <div class="form-search form-inline">
                    <form action="#" method="GET">
                        <input type="" class="form-control form-search" name="search" value="{{ request()->search }}" placeholder="Tìm tiêu đề">
                        <input type="submit" name="btn-action" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{url('admin/page/action/')}}" method="post">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option value="NUll">Chọn</option>
                        @foreach ($list_act as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-action" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Ngày cập nhật gần nhất</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($pages->total()>0)
                        @php
                        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $num_per_page + 1;
                        @endphp
                        @foreach ($pages as $page)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $page->id }}">
                            </td>
                            <td scope="row">{{$start++}}</td>
                            <td><a href="{{url('admin/page/edit/'.$page->id)}}">{{ Str::of($page->title)->limit(50) }}</a></td>
                            <td>
                                @foreach ($users as $user)
                                @if ($user->id == $page->user_id)
                                {{ $user->name }}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @if ($page->status == 1)
                                <span class="badge badge-primary">Công khai</span>
                                @else
                                <span class="badge badge-warning">Chờ duyệt</span>
                                @endif
                            </td>
                            <td>{{ $page->created_at }}</td>
                            <td>{{ $page->updated_at }}</td>
                            <td>
                                @can('edit-page')
                                <a href="{{url('admin/page/edit/'.$page->id)}}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete-page')
                                <a href="{{url('admin/page/delete/'.$page->id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endcan
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
                {{$pages->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
@endsection