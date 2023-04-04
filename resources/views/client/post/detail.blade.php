@extends('client.layouts.app')
@section('title')
Chi tiết Bài viết
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                        <a href="{{ url('24h-cong-nghe.html') }}" title="">24h Công nghệ</a>
                    </li>
                    <li>
                        <a href="" title="">Chi tiết bài viết</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title font-weight-bold">{{ $post->title }}</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">{{ $post->created_at->format('h:m d-m-20y') }}</span>
                    <div class="detail">
                        {!! $post->content !!}
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

