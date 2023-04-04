@php
$main_menu = main_menu();
@endphp

<div id="header-wp">
    <div id="head-top" class="clearfix">
        <div class="wp-inner">
            <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
            <div id="main-menu-wp" style="height: 44px;" class="fl-right">
                <ul id="main-menu" class="clearfix">
                    @foreach ($main_menu as $menu)
                    <li>
                        <a href="{{ url($menu->link) }}" title="">{{ $menu->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="head-body" class="clearfix">
        <div class="wp-inner">
            <a href="{{ url('/') }}" title="" id="logo" class="fl-left">VSMART</a>
            <div id="search-wp" class="fl-left">
                <form method="POST" action="{{ route('search') }}">
                    @csrf
                    <input type="text" value="{{ old('search') }}" name="search" id="s" data-url="{{ route('product.search') }}" data-detail="{{ url('chi-tiet-san-pham/') }}" placeholder="Nhập từ khóa tìm kiếm tại đây!" autocomplete="off">
                    <button type="submit" id="sm-s">Tìm kiếm</button>
                </form>
                <div class="result-ajax-search">
                </div>
            </div>
            <div id="action-wp" class="fl-right">
                <div id="advisory-wp" class="fl-left">
                    <span class="title">Tư vấn</span>
                    <span class="phone">0987.654.321</span>
                </div>
                <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                <a href="{{  route('cart.show') }}" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span id="num">{{ count(Cart::content()) }}</span>
                </a>
                <div id="cart-wp" class="fl-right">
                    <div id="btn-cart">
                        <a href="{{  route('cart.show') }}" style="color:#fff"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
                        <span id="num">{{ count(Cart::content()) }}</span>
                    </div>
                    <div id="dropdown" data-asset={{ url('') }} data-showCat="{{ route('cart.show') }}" data-checkout="{{ route('cart.checkout') }}">
                        @if (count(Cart::content()))
                        <p class="desc">Có <span class="num_header">{{ count(Cart::content()) }} sản phẩm</span> trong
                            giỏ hàng</p>
                        <ul class="list-cart">
                            @foreach (Cart::content() as $item)
                            <li class="clearfix">
                                <a href="" title="" class="thumb fl-left">
                                    <img src="{{ url($item->options->product_thumb) }}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="" title="" class="product-name">{{ Str::of($item->name)->limit(20) }}</a>
                                    <p class="price">
                                        {{ number_format($item->price, 0, '.', ',') }}đ
                                    </p>
                                    <p class="qty">Số lượng: <span class="qty_header-{{ $item->rowId }}">{{ $item->qty }}</span>
                                    </p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div class="total-price clearfix">
                            <p class="title fl-left">Tổng:</p>
                            <p class="price fl-right">{{ Cart::total() }}đ</p>
                        </div>
                        <div class="action-cart clearfix">
                            <a href="{{ route("cart.show") }}" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                            <a href="{{ route('cart.checkout') }}" title="Thanh toán" class="checkout fl-right">Thanh
                                toán</a>
                        </div>
                        @else
                        <div class="cart_empty">
                            <img style="width:80%;" src="{{ url('public/images/gio-hang.png') }}" alt="">
                            <p>Giỏ hàng chưa có sản phẩm nào</p>
                            <a class="shopping_now" href="{{ url('/') }}">Mua sắm ngay</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>