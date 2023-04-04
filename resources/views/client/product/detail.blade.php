@extends('client.layouts.app')
@section('title')
Chi tiết Sản phẩm
@endsection
@section('css')
    <link rel="stylesheet" href="{{ url('public/css/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/css/owlcarousel/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/solid.min.css">
@endsection
@section('gallery')
    <div class="gallery">
        <i class="fa-solid fa-xmark close"></i>
        <div class="inner">
            <img src="{{ url($product->product_thumb) }}" alt="">
        </div>
        <div class="control prev">
            <i class="fa-solid fa-angle-left"></i>
        </div>
        <div class="control next">
            <i class="fa-solid fa-angle-right"></i>
        </div>
    </div>
@endsection
@section('content')
    <div id="main-content-wp" class="clearfix detail-product-page">
        <div class="wp-inner">
            <div class="section" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Chi tiết sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="detail-product-wp">
                    <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                            <div class="img_big">
                                <img src="{{ url($product->product_thumb) }}" alt="">
                            </div>
                            <div class="section image" id="feature-product-wp">
                                <div class="section-detail">
                                    <ul class="list-item img_small">
                                        @foreach ($product->image_child as $image)
                                            <li>
                                                <img src="{{ url($image->image_path) }}" alt="">
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="info fl-right">
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="desc">
                                {!! $product->product_detail !!}
                            </div>
                            <div class="num-product">
                                <span class="title">Sản phẩm: </span>
                                <span class="status">Còn hàng({{ $product->num - $product->num_sold }})</span>
                            </div>
                            <p class="price">{{ number_format($product->price_real) }}đ</p>
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order" data-url="{{route('cart.add',$product->id)}}" readonly>
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <a href="{{ route('cart.add',$product->id)}}/1" title="Thêm giỏ hàng" class="add-cart-detail">Thêm giỏ hàng</a>
                        </div>
                    </div>

                </div>
                <div class="section" id="post-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Mô tả sản phẩm</h3>
                    </div>
                    <div class="section-detail product_desc">
                        <div class="see-next">
                            <span>Xem thêm</span>
                        </div>
                        {!! $product->product_desc !!}
                        <!-- hiển thị cấu trúc có định dạng html -->
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title"><span>Sản phẩm khác</span></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($products_same_cat as $product)
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
                                        <a href="" data-url="{{ route('cart.add',$product->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ
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
                        <ul class="list-item detail_product">
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
@section('js')
    <script src="{{ asset('client/product/main.js') }}"></script>
@endsection
