@extends('admin.layouts.app')
@section('title')
Thêm sản phẩm
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm sản phẩm
            </div>
            <div class="card-body">
                <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-strong" for="name">Tên sản phẩm</label>
                                                <input class="form-control slug" type="text" value="{{ old('name') }}"
                                                    name="name" id="name"
                                                    onkeyup="return ChangeToSlug('slug','convert_slug')">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <div class="col-4">
                                            <div class="form-group">
                                                <label class="text-strong" for="code">Mã sản phẩm</label>
                                                <input class="form-control" type="text" value="{{ old('code') }}"
                                                    name="code" id="code">
                                                @error('code')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="slug">Slug</label>
                                                <input class="form-control convert_slug" value="{{ old('slug') }}"
                                                    type="text" name="slug" id="slug">
                                                @error('slug')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="price">Giá</label>
                                                <input class="form-control" min=0 value="{{ old('price') }}" type="number"
                                                    name="price" id="price">
                                                @error('price')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="num">Số lượng</label>
                                                <input class="form-control" min=0 value="{{ old('num') }}" type="number"
                                                    name="num" id="num">
                                                @error('num')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="discount">Giảm giá</label>
                                                <input class="form-control" min=0 value="{{ old('discount') }}" type="number"
                                                    name="discount" id="discount">
                                                @error('discount')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="product_thumb">Ảnh đại diện</label>
                                                <!-- <input type="file" name="product_thumb"
                                                    value="" class="form-control-file"
                                                    id="product_thumb"> -->
                                                    <input type="file" name="product_thumb" class="form-control-file" value="{{old('product_thumb') }}" id="uploadImage" onchange="chooseFile(this)" type="file"  >
                                                    <img class="mt-2" style="max-width:150px;" src=""  id="image"><br>
                                                @error('product_thumb')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="text-strong" for="product_image">Ảnh mô tả</label>
                                                <input type="file" name="product_image[]"
                                                    value="{{old('product_image') }}" class="form-control-file"
                                                    id="product_image" multiple>
                                                    <!-- <input type="file" nname="product_image[]" class="form-control-file" value="{{ old('product_image') }}" id="uploadImage" onchange="chooseFile(this)" type="file" multiple  >
                                                    <img class="mt-2" style="max-width:150px;" src=""  id="image"><br> -->
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
                                                        @if (old('status') == 0) checked @endif type="radio"
                                                        name="status" id="exampleRadios1" value="0" checked>
                                                    <label class="form-check-label" for="exampleRadios1">
                                                        Chờ duyệt
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        @if (old('status') == 1 || old('status') == '') checked @endif type="radio"
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
                                                    <input type="checkbox" @if (old('featured') == 1) checked @endif
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
                                                        <option @if (old('cat_parent') == $cat->id) selected @endif
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
                                <textarea name="product_detail" class="form-control" id="product_detail" cols="30" rows="5">{{ old('product_detail') }}</textarea>
                                @error('product_detail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="text-strong" for="product_desc">Mô tả sản phẩm</label>
                                <textarea name="product_desc" class="form-control" id="product_desc" cols="30" rows="5">{{ old('product_desc') }}</textarea>
                                @error('product_desc')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
