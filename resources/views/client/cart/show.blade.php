@extends('client.layouts.app')
@section('title')
Giỏ hàng
@endsection
@section('content')
    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Giỏ hàng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="info-cart-wp">
                @if (count(Cart::content()) > 0)
                    <div class="section-detail table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Mã sản phẩm</td>
                                    <td>Ảnh sản phẩm</td>
                                    <td>Tên sản phẩm</td>
                                    <td>Giá sản phẩm</td>
                                    <td>Số lượng</td>
                                    <td>Thành tiền</td>
                                    <td>Tác vụ</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $item)
                                    <tr>
                                        <td>{{$item->options->code }}</td>
                                        <td>
                                            <a href="" title="" class="thumb">
                                                <img src="{{url($item->options->product_thumb)}}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('product.detail', $item->options->slug) }}" title=""
                                                class="name-product">{{ $item->name }}</a>
                                        </td>
                                        <td>{{number_format($item->price, 0, '.', ',') }}đ</td>
                                        <td>
                                            <input type="number" min=1 name="qty" value="{{ $item->qty }}" data-url="{{ route('cart.update',$item->rowId) }}"
                                                class="num-order">
                                        </td>
                                        <td class="sub_total-{{ $item->rowId }}">{{ $item->total() }}đ</td>
                                        <td>
                                            <a href="" data-url="{{ route('cart.remove', $item->rowId) }}" title="Xóa"
                                                class="del-product btn-delete"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-right ">Tổng giá: <span class="total_price">{{ Cart::total() }}đ</span>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <div class="fl-right">
                                                <a href="" data-url="{{route('cart.destroy') }}" title="" id="delete-cart" class="btn-delete">Xóa
                                                    toàn bộ giỏ hàng</a>
                                                <a href="{{route('cart.checkout') }}" title="" id="checkout-cart">Thanh toán</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="cart_empty">
                        <img src="{{ url('public/images/gio-hang.png') }}" alt="">
                        <p>Giỏ hàng chưa có sản phẩm nào</p>
                        <a class="shopping_now" href="{{ url('/') }}">Mua sắm ngay</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
@section('js')
  
@endsection
