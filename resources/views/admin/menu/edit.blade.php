@extends('admin.layouts.app')
@section('title')
Sửa Menu
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <form action="{{url('admin/menu/update/'.$menu->id)}}" method="post">
            @csrf
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Sửa menu
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-strong" for="name">Tên menu</label>
                                    <input class="form-control slug" type="text" value="{{ $menu->name }}"
                                        name="name" id="name" onkeyup="return ChangeToSlug('slug','convert_slug')">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-strong" for="slug">Slug</label>
                                    <input class="form-control convert_slug" value="{{$menu->slug}}" type="text"
                                        name="slug" id="slug">
                                    @error('slug')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="text-strong" for="link">Link</label>
                                    <input class="form-control" type="text" value="{{$menu->link}}" name="link"
                                        id="link">
                                    @error('link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-strong" for="link">Position</label>
                                    <input class="form-control" type="number" value="{{$menu->position}}" name="position"
                                        id="link">
                                    @error('position')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-strong" for="">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" @if ($menu->status == 0) checked @endif
                                            type="radio" name="status" id="exampleRadios1" value="0" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Chờ duyệt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" @if ($menu->status == 1) checked @endif
                                            type="radio" name="status" id="exampleRadios2" value="1">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Công khai
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection
