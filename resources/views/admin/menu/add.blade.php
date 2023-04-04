@extends('admin.layouts.app')
@section('title')
Thêm Menu
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <form action="{{url('admin/menu/store')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Thêm menu
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-strong" for="name">Tên menu</label>
                                    <input class="form-control slug" type="text" value="{{ old('name') }}"
                                        name="name" id="name" onkeyup="return ChangeToSlug('slug','convert_slug')">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="text-strong" for="slug">Slug</label>
                                    <input class="form-control convert_slug" value="{{ old('slug') }}" type="text"
                                        name="slug" id="slug">
                                    @error('slug')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="text-strong" for="link">Link</label>
                                    <input class="form-control" type="text" value="{{ old('link') }}" name="link"
                                        id="link">
                                    @error('link')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-strong" for="position">Position(number)</label>
                                    <input class="form-control" type="number" min=1 value="{{ old('position') }}" name="position"
                                        id="position">
                                    @error('position')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="text-strong" for="">Danh mục cha</label>
                                    <select class="form-control" id="" name="parent_id">
                                        <option value="0">Chọn danh mục</option>
                                        @if($listMenu)
                                        @foreach ($listMenu as $menu)
                                            <option @if (old('parent_id') == $menu->id) selected @endif
                                                value="{{ $menu->id }}">
                                                @php
                                                    echo str_repeat('---', $menu->level);
                                                @endphp
                                                {{ $menu->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="text-strong" for="">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" @if (old('status') == 0) checked @endif
                                            type="radio" name="status" id="exampleRadios1" value="0" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Chờ duyệt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" @if (old('status') == 1 || old('status') == '') checked @endif
                                            type="radio" name="status" id="exampleRadios2" value="1">
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
        </form>
    </div>
@endsection
