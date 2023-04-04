@extends('client.layouts.app')
@section('title')
Bài viết công Nghệ
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@endsection

@section('content')
    <div id="main-content-wp" class="clearfix blog-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="{{ url('24h-cong-nghe.html')}}" title="">24h Công nghệ</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title"><strong>Tin tức công nghệ</strong></h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($posts as $post)
                                {{-- @if ($post->cat_parent->status == 1) --}}
                                <li class="clearfix">
                                    <a href="{{ route('post.detail', $post->slug) }}" title="" class="thumb fl-left">
                                        <img class="featured_img" src="{{ url($post->featured_image_path) }}"
                                            alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="{{ route('post.detail', $post->slug) }}" title=""
                                            class="title font-weight-bold">{{ $post->title }}</a>
                                        <span class="create-date">{{ $post->created_at->format('h:m d-m-20y') }}</span>
                                        <p class="cat font-weight-bold">Chuyên mục: <span
                                                class="text-danger">{{ $post->cat_parent->name }}</span></p>
                                    </div>

                                </li>
                                {{-- @endif --}}
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="paging-wp">
                    <div class="section-detail float-right">
                        <ul class="list-item clearfix mt-1 ">
             {{$posts->links('pagination::bootstrap-4')}}

                        </ul>
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
