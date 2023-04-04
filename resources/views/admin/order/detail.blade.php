@extends('admin.layouts.app')
@section('title')
Chi tiết đơn hàng
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ url('public/admin/order/detail.css') }}">
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                <h5 class="m-0 ">Chi tiết đơn hàng {{ $order->order_code }}</h5>
            </div>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="{{ route('order.update', $order->order_code) }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="header">
                                        <h5 class="text-info" style="margin-bottom:20px;"> <i class="fas fa-signal"></i>
                                            Trạng
                                            thái đơn hàng:
                                            @if ($order->status == 1)
                                                <span class="badge badge-primary">Đang xử lí</span>
                                            @elseif ($order->status == 2)
                                                <span class="badge badge-danger">Đang vận chuyển</span>
                                            @elseif ($order->status == 3)
                                                <span class="badge badge-success"> Thành công</span>
                                            @else
                                                <span class="badge badge-dark">Hủy đơn</span>
                                            @endif
                                        </h5>
                                        <div class="col-6 mb-4">
                                            <div class="form-action form-inline">
                                                <select class="form-control mr-1" id="" name="status">
                                                    <option value="0">Cập nhật trạng thái đơn hàng</option>
                                                    <option value="1">Đang xử lí</option>
                                                    <option value="2">Đang vận chuyển</option>
                                                    <option value="3">Thành công</option>
                                                    <option value="4">Hủy đơn</option>
                                                </select>
                                                <input type="submit" name="btn-search" value="Áp dụng"
                                                    class="btn btn-primary">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="header">
                                        <h5 class="text-info" style="margin-bottom:20px;"> <i
                                                class="fas fa-info-circle"></i>
                                            Thông tin sản phẩm</h5>
                                    </div>
                                    <table class="table table-striped table-checkall">
                                        <thead>
                                            <th scope="col">#</th>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Tên sản phẩm</th>
                                            <th scope="col">Giá</th>
                                            <th scope="col"> Số lượng</th>
                                            <th scope="col">Thành tiền</th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $temp = 1;
                                            @endphp
                                            @foreach ($order->product as $item)
                                                <tr>
                                                    <td>{{ $temp++ }}</td>
                                                    <td><a class="feature_img" href=""><img
                                                                src="{{ url($item->product_thumb) }}" alt=""></a>
                                                    </td>
                                                    <td class="title">{{ Str::of($item->name)->limit(40) }}</td>
                                                    <td>{{ number_format($item->price) }}đ</td>
                                                    @foreach ($detail_order as $value)
                                                        @if ($value->product_id == $item->id)
                                                            <td>
                                                                {{ $value->qty }}
                                                            </td>
                                                            <td>{{ number_format($value->qty * $item->price) }}đ</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="font-weight:bold">Tổng</td>
                                                <td style="font-weight:bold">{{ $order->total_qty }}</td>
                                                <td style="font-weight:bold">{{ number_format($order->total_price) }}đ</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>


                        </div>
                        <div class="col-3">
                            <div class="header">
                                <h5 class="text-info" style="margin-bottom:20px;"> <i class="fas fa-question-circle"></i>
                                    Khách
                                    hàng</h5>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Họ và tên</h6>
                                    <p class="card-text">{{ $order->customer->name }}</p>
                                    <h6 class="card-title">Số điện thoại</h6>
                                    <p class="card-text">{{ $order->customer->phone }}</p>
                                    <h6 class="card-title">Email</h6>
                                    <p class="card-text">{{ $order->customer->email }}</p>
                                    <h6 class="card-title">Địa chỉ</h6>
                                    <p class="card-text">{{ $order->customer->address }}</p>
                                    <h6 class="card-title">Ngày đặt hàng</h6>
                                    <p class="card-text">{{ $order->created_at->translatedFormat('l j F Y') }}</p>
                                    <h6 class="card-title">Chú thích</h6>
                                    <p class="card-text">{{ $order->customer->note }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
