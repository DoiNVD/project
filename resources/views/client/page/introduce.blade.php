@extends('client.layouts.app')
@section('title')
Chi tiết Bài viết
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('public/client/page/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/client/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/client/product/style.css') }}">
@endsection

@section('content')
<div id="main-content-wp" class="clearfix detail-blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">{{ $page->title }}</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">{{ $page->created_at }}</span>
                    <div class="detail">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
            <div class="section" id="social-wp">
                <div class="section-detail">
                    <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    <div class="g-plusone-wp">
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                    <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($seller_products as $product)
                            <li class="clearfix">
                                <a href="{{ route('product.detail', $product->id) }}" title=""
                                    class="thumb fl-left">
                                    <img src="{{ asset($product->product_thumb) }}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="{{ route('product.detail', $product->id) }}" title=""
                                        class="product-name">{{ Str::of($product->name)->limit(23) }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($product->price - ($product->price * $product->discount) / 100) }}đ</span>
                                        @if ($product->discount > 0)
                                            <span class="old">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>
                                    <a href="" title="" class="buy-now">Mua ngay</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="?page=detail_product" title="" class="thumb">
                        <img src="{{ asset('public/images/banner.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
