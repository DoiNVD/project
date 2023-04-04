@extends('client.layouts.app')
@section('title')
Sản phẩm
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/solid.min.css"> --}}
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
                        @php
                            $listCat = [];
                            $listCat[] = $cat;
                        @endphp
                        @include('components.cat_parent', ['cat' => $cat, 'listCat' => $listCat])
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title fl-left cat_title">{{ $cat->name }}</h3>
                        <div class="filter-wp fl-right">
                            <div class="form-filter">
                                <form method="GET" action="" id="form-filter">
                                    @csrf
                                    <select name="filter" class='orderBy'>
                                        <option @if ($filter == 'default') selected @endif value="">Sắp xếp
                                        </option>
                                        <option @if ($filter == 'asc') selected @endif value="asc">Từ A-Z
                                        </option>
                                        <option @if ($filter == 'desc') selected @endif value="desc">Từ Z-A
                                        </option>
                                        <option @if ($filter == 'price_min') selected @endif value="price_min">Giá cao
                                            xuống thấp</option>
                                        <option @if ($filter == 'price_max') selected @endif value="price_max">Giá thấp
                                            lên cao</option>
                                    </select>
                                    {{-- <button type="submit">Lọc</button> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            @if(count($listProducts)>0)
                            @foreach ($listProducts as $product)
                                <li>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="thumb_big">
                                        <img class="zoom" src="{{url($product->product_thumb) }}">
                                    </a>
                                    <a href="{{ route('product.detail', $product->slug) }}" title=""
                                        class="product-name">{{ Str::of($product->name)->limit(20) }}</a>
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
                            @else
                            <p style="color:red">Không tồn tại sản phẩm</p>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="section" id="paging-wp">
                    <div class="section-detail">
                    {{$listProducts->links('pagination::bootstrap-4')}}
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
                                        <a href="{{route('product.cat', $cat->slug) }}"
                                            title="">{{ $cat->name }}</a>
                                        @include('components.child_menu', ['cat' => $cat])
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section" id="filter-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Bộ lọc</h3>
                    </div>
                    <div class="section-detail">
                        <div class="filter">
                            <div class="title">
                                <h5>Khoảng Giá</h5>
                            </div>

                            <form action="" method="GET" id="form-filter-price">
                                @csrf
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_1') checked @endif value="price_1"
                                                    id="price_1">
                                                <label for="price_1">Dưới 500.000đ</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_2') checked @endif value="price_2"
                                                    id="price_2">
                                                <label for="price_2">500.000đ -
                                                    1.000.000đ</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_3') checked @endif value="price_3"
                                                    id="price_3">
                                                <label for="price_3">1.000.000đ
                                                    -
                                                    5.000.000đ</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_4') checked @endif value="price_4"
                                                    id="price_4">
                                                <label for="price_4">5.000.000đ
                                                    -
                                                    10.000.000đ</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_5') checked @endif value="price_5"
                                                    id="price_5">
                                                <label for="price_5">10.000.000đ
                                                    -
                                                    15.000.000đ</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_6') checked @endif value="price_6"
                                                    id="price_6">
                                                <label for="price_6">15.000.000đ
                                                    -
                                                    20.000.000đ</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="radio" name="filter_price"
                                                    @if ($filter_price == 'price_7') checked @endif value="price_7"
                                                    id="price_7">
                                                <label for="price_7">Trên
                                                    20.000.000đ</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
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
                                        <img class="zoom" class="zoom" src="{{ url($product->product_thumb)}}" alt="">
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
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.orderBy').change(function() {
            $("#form-filter").submit();
        })
        $('input[type=radio][name=filter_price]').change(function() {
            $("#form-filter-price").submit();
        });
    </script>
@endsection
