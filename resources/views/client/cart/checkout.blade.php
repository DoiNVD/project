@extends('client.layouts.app')
@section('title')
Thanh toán
@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
@endsection
@section('content')
<form action="{{ route('cart.order')}}" method="POST">
    @csrf
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <form method="POST" action="" name="form-checkout">
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="fullname">Họ tên <span class="mandatory">(*)</span></label>
                                <input type="text" name="fullname" placeholder="Nhập họ tên" id="fullname" value="{{ old('fullname') }}">
                                @error('fullname')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="email">Email</label>
                                <input type="email" name="email" placeholder="Nhập email" id="email" value="{{ old('email') }}">
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="phone">Số điện thoại <span class="mandatory">(*)</span></label>
                                <input type="tel" name="phone" placeholder="Nhập số điện thoại" id="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="province">Tỉnh/Thành phố <span class="mandatory">(*)</span></label>
                                <select name="province" class="form-control" id="province" data-urlDistrict="{{ route('location.district') }}">
                                    <option value="" disabled selected>Chọn Tỉnh/Thành phố</option>
                                    @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="district">Quận/Huyện <span class="mandatory">(*)</span></label>
                                <select name="district" class="form-control" id="district" data-urlWard="{{ route('location.ward') }}">
                                    <option disabled selected value="">Chọn Quận/Huyện</option>
                                </select>
                                @error('district')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="ward">Phường/Xã <span class="mandatory">(*)</span></label>
                                <select name="ward" class="form-control" id="ward">
                                    <option disabled selected value="">Chọn Phường/Xã</option>
                                </select>
                                @error('ward')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="address">Địa chỉ <span class="mandatory">(*)</span></label>
                                <input type="text" name='address' placeholder="Ví dụ: 52, đường Trần Hưng Đạo" id="address" value="{{old('address')}}">
                                @error('address')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="notes">Ghi chú (<small style="font-size: 14px;color:rgb(112, 112, 112);">nếu
                                        có</small>)</label>
                                <textarea name="note" value="{{ old('address') }}"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count(Cart::content())>0)
                            @foreach (Cart::content() as $item)
                            <tr class="cart-item">
                                <td class="product-name">{{ Str::of($item->name)->limit(60) }}<strong class="product-quantity">x {{ $item->qty }}</strong></td>
                                <td class="product-total">{{ number_format($item->total, 0, '.', ',') }}đ</td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="cart-item">
                                <td class="product-name">
                                    <p style="color:red">Bạn chưa có sản phẩm trong giỏ hàng .<a href="{{ url('/') }}">Mua săm</a> </p>

                                </td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price">{{ Cart::total() }}đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <h3>Hình thức thanh toán</h3>
                        <ul id="payment_methods">
                            <li>
                                <input type="radio" id="payment-home" name="payment-method" checked value="payment-home">
                                <label for="payment-home">Thanh toán khi nhận hàng</label>
                            </li>
                        </ul>
                    </div>
                    <div class="place-order-wp clearfix">
                        <input type="submit" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection