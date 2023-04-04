@extends('admin.layouts.app')
@section('title')
Danh sách Menu
@endsection
@section('content')
<div id="content" class="container-fluid">
    <form action="{{url('admin/menu/add/')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        <h5 class="m-0 "> Danh sách menu</h5>
                        <div class="function">
                            @can('add-menu')
                            <a href="{{url('admin/menu/add/')}}" class="btn btn-success">Thêm mới</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th class="title" scope="col">Tên menu</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người tạo-Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($paginatedArray)>0)
                                @php
                                $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                                $start = ($page - 1) * $perPage + 1;
                                @endphp
                                @foreach ($paginatedArray as $menu)
                                <tr>
                                    <td scope="row">{{$start++}}</td>
                                    <td class="title">
                                        @php
                                        echo str_repeat('---', $menu['level']);
                                        @endphp
                                        {{ $menu['name']}}
                                    </td>
                                    <td>{{ $menu['slug']}}</td>
                                    <td>{{ $menu['link']}}</td>
                                    <td>{{ $menu['position']}}</td>
                                    <td>
                                        @if ($menu['status'] == 1)
                                        <span class="badge badge-primary">Công khai</span>
                                        @else
                                        <span class="badge badge-warning">Chờ duyệt</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($users as $user)
                                        @if ($user->id == $menu['user_id'])
                                        {{ $user->name }}
                                        @endif
                                        @endforeach
                                        <p>@php
                                            $date =$menu['created_at'] ;
                                          echo  $formatted_date = date('Y-m-d H:i:s', strtotime($date));
                                            @endphp

                                        </p>
                                    </td>

                                    <td>
                                        @can('edit-menu')
                                        <a href="{{url('admin/menu/edit/'.$menu['id'])}}" class="btn btn-success btn-sm rounded-0 text-white action_edit" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        @endcan

                                        @can('delete-menu')
                                        <a href="{{url('admin/menu/delete/'.$menu['id'])}}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm rounded-0 text-white " type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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
                            {{$paginatedArray->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                </div>
            </div>
    </form>

</div>
@endsection