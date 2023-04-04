@extends('client.layouts.app')
@section('title')
Đặt hàng thành công
@endsection
@section('content')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Đặt hàng thành công</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @if (count($cart)>0)
        <div id="orderSuccess" class="wp-inner">
            <div class="section">
                <h3 class="title">Đặt hàng thành công !</h3>
                <h3>Cảm ơn quý khách đã đặt hàng tại Vsmart của chúng tôi</h3>
                <h3>ĐƠn hàng của quý khác đã được gởi đên email <a href="https://mail.google.com/mail/u/0/#inbox" target="_blank">{{ $customer->email }}</a>quý khách vui kiểm tra lại thông tin</h3>
            </div>
            <div class="info">
                <p><strong>MÃ ĐƠN: {{ $order->order_code }}</strong></p>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="header">
                            <h5 class="text-info" style="margin-bottom:20px;"> <i class="fas fa-info-circle"></i>
                                Thông tin khách hàng</h5>
                        </div>
                        <table class="table table-striped table-checkall">
                            <thead>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Email</th>
                                <th class="title" scope="col">Số điện thoại</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->address }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td class="title">{{ $order->customer->phone }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="header">
                            <h5 class="text-info" style="margin-bottom:20px;"> <i class="fas fa-info-circle"></i>
                                Thông tin sản phẩm</h5>
                        </div>
                        <table class="table table-striped table-checkall" >
                            <thead>
                                <th scope="col">#</th>
                                <th class="title" scope="col">Ảnh</th>
                                <th class="title" scope="col">Tên sản phẩm</th>
                                <th class="title" scope="col">Giá</th>
                                <th class="title" scope="col"> Số lượng</th>
                                <th class="title" scope="col">Thành tiền</th>
                            </thead>
                            <tbody>
                                @php
                                    $temp = 1;
                                @endphp
                                @foreach ($cart as $item)
                                    <tr>
                                        <td class="title" style="position: relative;
                                        transform: translateY(33%);">{{ $temp++ }}</td>
                                        <td class="title"><img style="max-width:100px;" src="{{ asset($item->options->product_thumb) }}"
                                                    alt="">
                                        </td>
                                        <td class="title" style="position: relative;
                                        transform: translateY(33%);">{{ $item->name }}</td>
                                        <td class="title" style="position: relative;
                                        transform: translateY(33%);">{{ number_format($item->price,0,'.',',') }}đ</td>
                                        <td class="title" style="position: relative;
                                        transform: translateY(33%);">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="title" style="position: relative;
                                        transform: translateY(33%);">{{ number_format($item->price*$item->qty,0,'.',',') }}đ</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4"></td>
                                    <td class="title" style="font-weight:bold">Tổng</td>
                                    <td class="title" style="font-weight:bold">{{ $total}}đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="section mt-4">
                    <a href="{{ url('/') }}" class="btn btn-dark">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
        @else
        <div id="content-complete">
            <p class="text-danger text-center pt-4" style="font-size:30px;"> Không Có Sản Phẩm Cần Mua Trong Trang Này!
            </p>
            <p class="text-dark text-center" style="font-size:18px;"> Vui Lòng Click Bên Dưới để Mua Hàng Tại hệ thống Vsmart Xin Cảm ơn !</p>
        </div>
        <div class="section mt-4 text-center">
            <a href="{{ url('/') }}" class="btn btn-dark">Quay lại trang chủ</a>
        </div>
        @endif

    </div>
@endsection
