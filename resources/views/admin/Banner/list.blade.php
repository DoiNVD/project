@extends('admin.layouts.app')
@section('title')
Danh sách Banner
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
            <h5 class="m-0 ">Danh sách Banner</h5>
            @can('add-banner')
            <a href="{{url('admin/banner/add/')}}" class="btn btn-success">Thêm mới</a>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Link</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Người tạo-Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if($banners->total()>0)
                    @php
                    $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $num_per_page + 1;
                    @endphp
                    @foreach ($banners as $banner)
                    <tr>
                        <td scope="row">{{$start++}}</td>
                        <td><a class="feature_img" href=""><img src="{{ url($banner->image_path) }}" alt=""></a></td>
                        <td>{{$banner->title}}</td>
                        <td>{{$banner->description}}</td>
                        <td>{{$banner->link}}</td>
                        <td>
                            @if ($banner->status == 1)
                            <span class="badge badge-primary">Công khai</span>
                            @else
                            <span class="badge badge-warning">Chờ duyệt</span>
                            @endif
                        </td>
                        <td>
                            @foreach ($users as $user)
                            @if ($user->id == $banner->user_id)
                            {{ $user->name }}
                            @endif
                            @endforeach
                            <p>{{$banner->created_at }}</p>
                        </td>
                        <td>
                            @can('edit-banner')
                            <a href="{{url('admin/banner/edit/'.$banner->id)}}" class="btn btn-success btn-sm rounded-0 text-white action_edit" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            @endcan
                            @can('delete-banner')
                            <a href="#" data-url="{{url('admin/banner/delete/'.$banner->id)}}" class="btn btn-danger btn-sm rounded-0 text-white btn-delete" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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
            <div>
                {{$banners->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>

@endsection