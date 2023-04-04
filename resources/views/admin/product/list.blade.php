@extends('admin.layouts.app')
@section('title')
Danh sách sản phẩm
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
            <div class="function">
                @can('add-product')
                <a href="{{ route('product.add') }}" class="btn btn-success">Thêm mới</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="analytic d-flex justify-content-between">
                <div class="status">
                    <a href="{{ route('product.list') }}" class="text-primary">Tất cả<span class="text-muted">({{ count($product_all) }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'public']) }}" class="text-primary">Đã
                        đăng<span class="text-muted">({{ count($product_public) }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                        duyệt<span class="text-muted">({{ count($product_pending) }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng
                        rác<span class="text-muted">({{ count($product_trash) }})</span></a>
                </div>

                <div class="form-search form-inline">
                    <form action="#" method="GET">
                        <input type="" class="form-control form-search" name="search" value="{{ request()->search }}" placeholder="Tìm tên sản phẩm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <form action="{{ route('product.action') }}" method="post">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option>Chọn</option>
                        @foreach ($list_act as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Giảm giá</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người tạo-Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($products->total()>0)
                        @php
                        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $num_per_page + 1;
                        @endphp
                        @foreach ($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $product->id }}">
                            </td>
                            <td scope="row">{{$start++}}</td>
                            <td><a class="feature_img" href="{{ route('product.edit', $product->id) }}"><img src="{{ url($product->product_thumb) }}" alt=""></a></td>
                            <td class="title"><a href="{{ route('product.edit', $product->id) }}">{{ Str::of($product->name)->limit(30) }}</a>
                            </td>
                            <td>{{number_format($product->price) }}đ</td>
                            <td>{{ $product->discount }}%</td>
                            <td class="center">
                                <span class="badge badge-success">
                                    @foreach ($listCat as $cat)
                                    @if ($cat->id == $product->cat_id)
                                    <span>{{ $cat->name }}</span>
                                    @endif
                                    @endforeach
                                </span>

                            </td>
                            <td class="center">
                                @if ($product->num > 0)
                                <span class="badge badge-primary">còn hàng({{ $product->num }})</span>
                                @else
                                <span class="badge badge-warning">Hết hàng</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($users as $user)
                                @if ($user->id == $product->user_id)
                                {{ $user->name }}
                                @endif
                                @endforeach
                                <p>{{ $product->created_at }}</p>
                            </td>
                            <td>
                                @can('edit-product')
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete-product')
                                <a href="{{ route('product.delete', $product->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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
                {{$products->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
</div>
@endsection