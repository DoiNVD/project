@extends('admin.layouts.app')
@section('title')
Danh sách Danh mục sản phẩm
@endsection
@section('content')
<div id="content" class="container-fluid">
    <form action="{{ route('product.cat.store') }}" method="post">
        @csrf
        <div class="row">
            @can('add-category-product')
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm danh mục sản phẩm
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label class="text-strong" for="name">Tên danh mục</label>
                            <input class="form-control slug" onkeyup="return ChangeToSlug('slug','convert_slug')" type="text" value="{{ old('name') }}" name="name" id="name">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-strong" for="slug">Slug</label>
                            <input class="form-control convert_slug" value="{{ old('slug') }}" type="text" name="slug" id="slug">
                            @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="text-strong" for="">Danh mục cha</label>
                            <select class="form-control" id="" name="cat_parent">
                                <option value="0">Chọn danh mục</option>
                                @foreach ($list_cat_mutiple_menu as $cat)
                                <option @if (old('cat_parent')==$cat->id) selected @endif
                                    value="{{ $cat->id }}">
                                    @php
                                    echo str_repeat('---', $cat->level);
                                    @endphp
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="text-strong" for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" @if (old('status')==0) checked @endif type="radio" name="status" id="exampleRadios1" value="0" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" @if (old('status')==1 || old('status')=='' ) checked @endif type="radio" name="status" id="exampleRadios2" value="1">
                                <label class="form-check-label" for="exampleRadios2">
                                    Công khai
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </div>
            @endcan
            <div class="col-8">
                <div class="card">
                    @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th class="title" scope="col">Tên danh mục</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $temp = 1;
                                @endphp

                                @foreach ($list_cat_mutiple_menu as $catItem)
                                <tr>
                                    <td scope="row">{{ $temp++ }}</td>
                                    <td class="title">
                                        @php
                                        echo str_repeat('---', $catItem->level);
                                        @endphp
                                        {{ Str::of($catItem->name)->limit(35) }}
                                    </td>
                                    <td>
                                        @if ($catItem->status == 1)
                                        <span class="badge badge-primary">Công khai</span>
                                        @else
                                        <span class="badge badge-warning">Chờ duyệt</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($users as $user)
                                        @if ($user->id == $catItem->user_id)
                                        {{ $user->name }}
                                        @endif
                                        @endforeach
                                    </td>

                                    <td>{{ $catItem->created_at }}</td>
                                    <td>
                                        @can('edit-category-product')
                                        <a href="{{ route('product.cat.edit', $catItem->id) }}" class="btn btn-success btn-sm rounded-0 text-white action_edit" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        @endcan

                                        @can('delete-category-product')
                                        <a href="{{ route('product.cat.delete', $catItem->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn danh mục này không?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </form>
</div>
@endsection