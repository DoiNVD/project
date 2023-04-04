@extends('admin.layouts.app')
@section('title')
Sửa Permisson
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Sửa quyền
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/permission/update/'.$permission->id)}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-strong" for="name">Tên quyền</label>
                        <input class="form-control" type="text" value="{{ $permission->name }}" name="name"
                            id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text-strong" for="display_name">Mô tả quyền</label>
                        <input class="form-control" type="text" value="{{ $permission->display_name }}"
                            name="display_name" id="display_name">
                        @error('display_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                    <label class="text-strong" for="key_code">Nhập key_code</label><small style="font-size: 15px;color: #656363;font-weight: normal;">(action_module). Ví dụ: Danh sách sản phẩm -&gt; key_code=list_product, Danh sách danh mục sản phẩm -&gt; key_code=list_category_product</small>
                        <input class="form-control" type="text" value="{{ $permission->key_code }}" name="key_code"
                            id="key_code">
                        @error('key_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="action mb-4">
                    <label class="text-strong" for="">Chọn module cha</label><small style="font-size: 15px;color: #656363;font-weight: normal;">(Không chọn nếu là danh mục cha)</small>
                        <select class="form-control mr-1" name='permission_parent' id="">
                            <option value="0">Chọn</option>
                            @if ($permission->parent_id != 0)
                                @foreach ($permissionParent as $item)
                                    <option @if ($item->id == $permission->parent_id) selected @endif value="{{ $item->id }}">
                                        {{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <input type="submit" name="btn-edit" class="btn btn-primary" value="Cập nhật">
                </form>
            </div>
        </div>
    </div>
@endsection

