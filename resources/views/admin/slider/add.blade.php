@extends('admin.layouts.app')
@section('title')
Thêm slider
@endsection
@section('content')
<div id="content" class="container-fluid">
    <form action="{{url('admin/slider/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm slider
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-strong" for="title">Tiêu đề</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="title">
                                @error('title')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="text-strong" for="image_path">Ảnh</label>
                                <input type="file" name="image_path" class="form-control-file" id="uploadImage" onchange="chooseFile(this)" type="file" name="avatar" accept=".jpg,.jpeg,.png">
                                <img class="mt-2" style="max-width:150px;" src=""  id="image"><br>
                                @error('image_path')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                             
                            </div>
                            <div class="form-group">
                                <label class="text-strong" for="description">Mô tả ngắn</label>
                                <input type="text" name="description" value="{{ old('description') }}" class="form-control" id="description">
                                @error('description')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="text-strong" for="link">Link</label>
                                <input type="text" name="link" value="{{ old('link') }}" class="form-control" id="link">
                                @error('link')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="text-strong" for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" @if (old('status')==0) checked @endif type="radio" name="status" id="exampleRadios1" value="0" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" @if (old('status')==1 || old('status')=='' ) checked @endif type="radio" name="status" id="exampleRadios2" value="1">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection