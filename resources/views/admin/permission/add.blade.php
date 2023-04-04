@extends('admin.layouts.app')
@section('title')
Tạo mới quyền
@endsection
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if(Session::has('status'))
        <div class="alert alert-success">
            {{ Session::get('status') }}
            @php
            Session::forget('status');
            @endphp
        </div>
        @endif
        <div class="card-header font-weight-bold">
            Thêm quyền
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/permission/store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="text-strong" for="name">Tên quyền</label>
                    <input class="form-control" type="text" value="{{ old('name') }}" name="name" id="name" >
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-strong" for="display_name">Mô tả quyền</label>
                    <input class="form-control" type="text" value="{{ old('display_name') }}" name="display_name" id="display_name" >
                    @error('display_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="text-strong" for="key_code">Nhập key_code</label><small style="font-size: 15px;color: #656363;font-weight: normal;">(action_module). Ví dụ: Danh sách sản phẩm -&gt; key_code=list_product, Danh sách danh mục sản phẩm -&gt; key_code=list_category_product</small>
                    <input class="form-control" type="text" value="{{ old('key_code') }}" name="key_code" id="key_code">
                    @error('key_code')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="action mb-4">
                    <label class="text-strong" for="">Chọn module cha</label><small style="font-size: 15px;color: #656363;font-weight: normal;">(Không chọn nếu là danh mục cha)</small>
                    <select class="form-control mr-1" name='parent_id' id="">
                        <option value="0">Chọn</option>
                        @foreach ($permissionParent as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                    </select>
                </div>
                <input type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">
            </form>
        </div>
    </div>
</div>
@endsection