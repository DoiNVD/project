@extends('client.layouts.app')
@section('title')
Trang
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
                        <a href="" title="">{{ $page->title }}</a>
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
                    <span class="create-date">{{ $page->created_at->format('h:m d-m-20y') }}</span>
                    <div class="detail">
                        {!! $page->content !!}
                        @if(($page->title) =="Liên hệ")
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d122985.06978269905!2d108.4286684858015!3d15.576498391177061!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3169dcc1b9922cc9%3A0x15678bdf2baff71!2zVHAuIFRhbSBL4buzLCBRdeG6o25nIE5hbSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1680335503297!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                         @endif   
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
                            <a href="{{ route('product.detail', $product->slug) }}" title="" class="thumb fl-left">
                                <img class="zoom" src="{{ url($product->product_thumb) }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('product.detail', $product->slug) }}" title="" class="product-name">{{ Str::of($product->name)->limit(23) }}</a>
                                <div class="price">
                                    <span class="new">{{ number_format($product->price_real) }}đ</span>
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
                        <img src="{{ asset($banner->image_path) }}" alt="">
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection