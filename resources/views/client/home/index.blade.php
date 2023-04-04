@extends('client.layouts.app')
@section('title')
Trang chủ
@endsection
@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="slider-wp">
                    <div class="section-detail">
                        @foreach ($sliders as $slider)
                            <div class="item">
                                <img src="{{ url($slider->image_path) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-1.png">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-2.png">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-3.png">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-4.png">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="public/images/icon-5.png">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><span>Sản phẩm nổi bật</span></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($featured_products as $product)
                                <li>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="thumb_big">
                                        <img class="zoom" src="{{ url($product->product_thumb) }}">
                                    </a>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="product-name">{{ Str::of($product->name)->limit(23) }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($product->price_real) }}đ</span>
                                        @if ($product->discount > 0)
                                            <span class="old">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart.show') }}" data-url="{{ route('cart.add',$product->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ
                                            hàng</a>
                                        <a href="{{ route('cart.buy_now',$product->slug) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><span>Sản phẩm đang giảm giá</span></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($discount_products as $product)
                                <li>
                                    <div class="discount">
                                        <img src="{{ url('public/images/sale-tag.png') }}" alt="">
                                    </div>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="thumb_big">
                                        <img class="zoom" src="{{ url($product->product_thumb) }}">
                                    </a>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="product-name">{{ Str::of($product->name)->limit(23) }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($product->price_real) }}đ</span>
                                        @if ($product->discount > 0)
                                            <span class="old">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart.show') }}" data-url="{{ route('cart.add',$product->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ
                                            hàng</a>
                                        <a href="{{ route('cart.buy_now',$product->slug) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="list-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><span>Sản phẩm mới nhất</span></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @foreach ($newest_products as $product)
                                <li>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="thumb_big">
                                        <img class="zoom" src="{{ url($product->product_thumb) }}">
                                    </a>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="product-name">{{ Str::of($product->name)->limit(23) }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($product->price_real) }}đ</span>
                                        @if ($product->discount > 0)
                                            <span class="old">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>
                                    <div class="action clearfix">
                                        <a href="{{ route('cart.show') }}" data-url="{{ route('cart.add',$product->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ
                                            hàng</a>
                                        <a href="{{ route('cart.buy_now',$product->slug) }}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        <ul class="list-item">
                            @foreach ($listCatParents as $cat)
                                @if ($cat->status == 1)
                                    <li>
                                        <a href="{{ route('product.cat', $cat->slug) }}"
                                            title="">{{ $cat->name }}</a>
                                        @include('components.child_menu', ['cat' => $cat])
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="selling-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm bán chạy</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($seller_products as $product)
                                <li class="clearfix">
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="thumb fl-left">
                                        <img class="zoom" src="{{ url($product->product_thumb) }}" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="{{ route('product.detail', $product->slug) }}" title=""
                                            class="product-name">{{ Str::of($product->name)->limit(23) }}</a>
                                        <div class="price">
                                            <span
                                                class="new">{{ number_format($product->price_real) }}đ</span>
                                            @if ($product->discount > 0)
                                                <span class="old">{{ number_format($product->price) }}đ</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('cart.buy_now',$product->slug) }}" title="" class="buy-now">Mua ngay</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        @foreach ($banners as $banner)
                            <a href="" title="" class="thumb">
                                <img src="{{ url($banner->image_path) }}" alt="">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
