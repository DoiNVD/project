@extends('admin.layouts.app')
@section('title')
Danh sách dơn hàng
@endsection
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="#" method="GET">
                    <input type="" class="form-control form-search" name="search" value="{{ request()->search }}" placeholder="Tìm kiếm theo tên khách hàng">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show">
            {{session('status')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card-body">
            <div class="analytic">
                <a href="{{ route('order.list') }}" class="text-primary">Tất cả<span class="text-muted">({{ count($order_all) }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Đang xử
                    lí<span class="text-muted">({{ count($order_pending) }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'driving']) }}" class="text-primary">Đang vận
                    chuyển<span class="text-muted">({{ count($order_driving) }})</span></a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'success']) }}" class="text-primary">Thành
                    công<span class="text-muted">({{ count($order_success) }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'cancel']) }}" class="text-primary">Hủy đơn<span class="text-muted">({{ count($order_cancel) }})</span></a>
            </div>
            <form action="{{ route('order.action') }}" method="post">
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
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Số lượng sản phẩm</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái đơn hàng</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($orders->total()>0)
                        @php
                        $page = !empty($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $num_per_page + 1;
                        @endphp
                        @foreach ($orders as $order)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $order->id }}">
                            </td>
                            <td>{{ $start++ }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>
                                <p>{{ $order->customer->name }}</p>
                                <p>{{ $order->customer->phone }}</p>
                            </td>
                            <td>
                                {{ $order->total_qty }}
                            </td>
                            <td>{{number_format($order->total_price)}}đ</td>
                            <td>
                                @if ($order->status == 1)
                                <span class="badge badge-primary">Đang xử lí</span>
                                @elseif($order->status == 2)
                                <span class="badge badge-danger">Đang vận chuyển</span>
                                @elseif($order->status == 3)
                                <span class="badge badge-success">Thành công</span>
                                @else
                                <span class="badge badge-dark">Hủy đơn</span>
                                @endif

                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                @can('edit-order')
                                <a href="{{ route('order.detail', $order->order_code) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @endcan
                                @can('delete-order')
                                <a href="{{ route('order.delete', $order->order_code) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
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
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    {{$orders->links('pagination::bootstrap-4')}}
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection