@extends('admin.layouts.app')
@section('title')
Sửa Trang
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
               Sửa Trang
            </div>
            <div class="card-body">
                <form action="{{url('admin/page/update/'.$page->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-strong" for="title">Tiêu đề trang</label>
                        <input class="form-control slug" type="text" value="{{ $page->title }}" name="title"
                            id="title" onkeyup="return ChangeToSlug('slug','convert_slug')">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-strong" for="slug">Slug</label>
                        <input class="form-control convert_slug" value="{{$page->slug}}" type="text" name="slug"
                            id="slug">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-strong" for="content">Nội dung trang</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="5">{{ $page->content }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-strong" for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" @if ($page->status == 0) checked @endif type="radio"
                                name="status" id="exampleRadios1" value="0" checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" @if ($page->status == 1) checked @endif type="radio"
                                name="status" id="exampleRadios2" value="1">
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection


