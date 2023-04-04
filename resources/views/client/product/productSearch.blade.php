@extends('client.layouts.app')
@section('title')
Tìm kiếm Sản phẩm
@endsection
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Tìm kiếm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                @if (count($product_searched) > 0)
                    <div class="section" id="list-product-wp">
                        <div class="section-head clearfix">
                            <h3 class="section-title fl-left cat_title">Tìm thấy {{ count($product_searched) }} sản phẩm cho từ khóa
                                "{{ $search }}"</h3>x`
                        </div>
                        <div class="section-detail">
                            <ul class="list-item clearfix">
                                @foreach ($product_searched as $product)
                                    <li>
                                        <a href="{{ route('product.detail', $product->slug) }}" title=""
                                            class="thumb_big">
                                            <img class="zoom" src="{{ url($product->product_thumb) }}">
                                        </a>
                                        <a href="{{ route('product.detail', $product->slug) }}" title=""
                                            class="product-name">{{ Str::of($product->name)->limit(20) }}</a>
                                        <div class="price">
                                            <span
                                                class="new">{{ number_format($product->price - ($product->price * $product->discount) / 100) }}đ</span>
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
                    <div class="section" id="paging-wp">
                        <div class="section-detail">
                        {{$product_searched->links('pagination::bootstrap-4')}}
                        </div>
                    </div>
                @else
                    <div class="section no_see d-flex justify-content-center align-items-center flex-md-column mt-4" >
                        <img class="w-25" src="{{ asset('public/images/icon_no_see.png')}}" alt="">
                        <p class="mt-4">Không tìm thấy sản phẩm nào</p>
                    </div>
                @endif
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
                                        <a href="{{route('product.cat', $cat->slug) }}"
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
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

