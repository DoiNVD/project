@extends('admin.layouts.app')
@section('title')
Thêm bài viết
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-strong" for="title">Tiêu đề bài viết</label>
                        <input class="form-control slug" type="text" value="{{ old('title') }}" name="title"
                            id="title" onkeyup="return ChangeToSlug('slug','convert_slug')">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-strong" for="slug">Slug</label>
                        <input class="form-control convert_slug" value="{{ old('slug') }}" type="text" name="slug"
                            id="slug">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="text-strong" for="avatar">Chọn ảnh đại diện bài viết</label>
                                <!-- <input type="file" name="featured_image" value="{{ old('featured_image') }}"class="form-control-file" id="avatar"> -->
                                    <input type="file" name="featured_image" class="form-control-file" value="{{ old('featured_image') }}" id="uploadImage" onchange="chooseFile(this)" type="file" name="avatar" accept=".jpg,.jpeg,.png">
                                <img class="mt-2" style="max-width:150px;" src=""  id="image"><br>
                                @error('featured_image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
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

                    <div class="form-group">
                        <label class="text-strong" for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{ old('content') }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-strong" for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" @if (old('status') == 0) checked @endif type="radio"
                                name="status" id="exampleRadios1" value="0" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" @if (old('status') == 1 || old('status') == '') checked @endif type="radio"
                                name="status" id="exampleRadios2" value="1">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

