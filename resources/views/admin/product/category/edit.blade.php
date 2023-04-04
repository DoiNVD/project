@extends('admin.layouts.app')
@section('title')
Sửa danh mục sản phẩm
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <form action="{{ route('product.cat.update', $catProduct->id) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header font-weight-bold">
                            Sửa danh mục sản phẩm
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="text-strong" for="name">Tên danh mục</label>
                                <input class="form-control slug" onkeyup="return ChangeToSlug('slug','convert_slug')"
                                    type="text" value="{{ $catProduct->name }}" name="name" id="name">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label class="text-strong" for="slug">Slug</label>
                                <input class="form-control convert_slug" value="{{ $catProduct->slug }}" type="text"
                                    name="slug" id="slug">
                                @error('slug')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="text-strong" for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" @if ($catProduct->status == 0) checked @endif
                                        type="radio" name="status" id="exampleRadios1" value="0" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" @if ($catProduct->status == 1) checked @endif
                                        type="radio" name="status" id="exampleRadios2" value="1">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection

