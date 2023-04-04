@extends('admin.layouts.app')
@section('title')
Dashboard
@endsection
@section('css')
    <link rel="stylesheet" href="{{ url('public/admin/dashboard/style.css') }}">
@endsection
@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ count($order_success) }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ count($order_pending) }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">ĐANG VẬN CHUYỂN</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ count($order_driving) }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng đang vận chuyển</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($revenue) }}đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ count($order_cancel) }} ĐƠN</h5>
                        <p class="card-text">Đơn hàng bị hủy</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">TỔNG SẢN PHẨM TRONG KHO</div>
                    <div class="card-body">
                        <h5 class="card-title">{{$total_product }} SẢN PHẨM</h5>
                        <p class="card-text">Số lượng sản phẩm trong kho</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-light mb-3" style="color:#000!important;">
                    <div class="card-header">TỔNG SẢN PHẨM BÁN RA</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $total_product_sell }} SẢN PHẨM</h5>
                        <p class="card-text">Số lượng sản phẩm đã bán</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Số lượng sản phẩm</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Trạng thái đơn hàng</th>
                            <th scope="col">Ngày đặt hàng</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $temp = 1;
                        @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $temp++ }}</td>
                                <td>{{ $order->order_code }}</td>
                                <td>
                                    <p>{{ $order->customer->name }}</p>
                                    <p>{{ $order->customer->phone }}</p>
                                </td>
                                <td>
                                    {{ $order->total_qty }}
                                </td>
                                <td> {{number_format($order->total_price)}}đ</td>
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
                                    <a href="{{ route('order.detail', $order->order_code) }}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                            class="fa fa-edit"></i></a>
                                    <a href="{{ route('order.delete', $order->order_code) }}"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa không?');"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{ $orders->links() }}
                    </ul>
                </nav> --}}
            </div>
        </div>

    </div>
@endsection
