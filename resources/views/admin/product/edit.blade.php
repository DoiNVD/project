@extends('admin.layouts.app')
@section('title')
sửa sản phẩm
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-strong" for="name">Tên sản phẩm</label>
                                                <input class="form-control slug" type="text" value="{{ $product->name }}"
                                                    name="name" id="name"
                                                    onkeyup="return ChangeToSlug('slug','convert_slug')">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="slug">Slug</label>
                                                <input class="form-control convert_slug" value="{{ $product->slug }}"
                                                    type="text" name="slug" id="slug">
                                                @error('slug')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="price">Giá</label>
                                                <input class="form-control" min=0 value="{{ $product->price }}" type="number"
                                                    name="price" id="price">
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="num">Số lượng</label>
                                                <input class="form-control" min=0 value="{{$product->num}}" type="number"
                                                    name="num" id="num">
                                                @error('num')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="discount">Giảm giá</label>
                                                <input class="form-control" min=0 value="{{$product->discount}}" type="number"
                                                    name="discount" id="discount">
                                                @error('discount')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="product_thumb">Ảnh đại diện</label>
                                                <input type="file" name="product_thumb" value=""
                                                    class="form-control-file" id="uploadImage" onchange="chooseFile(this)">
                                                    <input type="hidden" name="product_thumb_old" value="{{ $product->product_thumb }}">
                                                <img class="mt-2" style="max-width:150px;"  src="{{ url($product->product_thumb) }}" alt=""  id="image">
                                                  
                                                @error('product_thumb')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="product_image">Ảnh mô tả</label>
                                                <input type="file" name="product_image[]" value=""
                                                    class="form-control-file" id="product_image" multiple>
                                                <div style="width:320px;flex-wrap:wrap;"
                                                    class="image_describe d-flex justify-content-between">
                                                    @foreach ($product->image_child as $image)
                                                        <div class="image">
                                                            <img class="mt-2 mr-2" style="max-width:150px;"
                                                                src="{{ url($image->image_path) }}" alt="">
                                                                <a href="{{ route('product.delete_image_child',$image->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa
                                                                </a>

                                                        </div>
                                                    @endforeach
                                                </div>
                                                @error('product_image')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="">Trạng thái</label>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        @if ($product->status == 0) checked @endif type="radio"
                                                        name="status" id="exampleRadios1" value="0" checked>
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Chờ duyệt
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        @if ($product->status == 1) checked @endif type="radio"
                                                        name="status" id="exampleRadios2" value="1">
                                                    <label class="form-check-label" for="exampleRadios2">
                                                        Công khai
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label style="padding-left: 19px;" class="text-strong" for="">Nổi
                                                    bật</label>
                                                <div class="form-check">
                                                    <input type="checkbox" @if ($product->product_featured == 1) checked @endif
                                                        value="1" name="featured" id="featured">
                                                    <label for="featured">Sản phẩm nổi bật</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-strong" for="">Danh mục cha</label>
                                                <select class="form-control" id="" name="cat_parent">
                                                    <option value="">Chọn danh mục</option>
                                                    @foreach ($list_cat_mutiple_menu as $cat)
                                                        <option @if ($product->cat_id == $cat->id) selected @endif
                                                            value="{{ $cat->id }}">

                                                            @php
                                                                echo str_repeat('---', $cat->level);
                                                            @endphp
                                                            {{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cat_parent')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label class="text-strong" for="product_detail">Chi tiết sản phẩm</label>
                                <textarea name="product_detail" class="form-control" id="product_detail" cols="30" rows="5">{{ $product->product_detail }}</textarea>
                                @error('product_detail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="text-strong" for="product_desc">Mô tả sản phẩm</label>
                                <textarea name="product_desc" class="form-control" id="product_desc" cols="30" rows="5">{{ $product->product_desc }}</textarea>
                                @error('product_desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
