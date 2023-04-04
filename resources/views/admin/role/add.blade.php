@extends('admin.layouts.app')
@section('title')
Tạo mới vai trò
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm vai trò
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/role/store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-strong" for="name">Tên vai trò</label>
                        <input class="form-control" type="text" value="{{ old('name') }}" name="name"
                            id="name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text-strong" for="display_name">Mô tả vai trò</label>
                        <input class="form-control" type="text" value="{{ old('display_name') }}" name="display_name"
                            id="display_name">
                        @error('display_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="checkall mt-4 display-6">
                        <input type="checkbox" name="checkall" id="check_all">
                        <label for="check_all"><strong>Chọn tất cả các vai trò</strong></label>
                    </div>

                    @foreach ($permissionParent as $permissionParentItem)
                        <div class="card my-4 border-success card-checkbox">
                            <div class="card-header w-100 text-white bg-success hello">
                                <input type="checkbox" class="checkbox_parent" name=""
                                    id="item-{{ $permissionParentItem->id }}">
                                <label for="item-{{ $permissionParentItem->id }}">Module
                                    {{ $permissionParentItem->name }}</label>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    @foreach ($permissionParentItem->permissionChild as $item)
                                 
                                        <div class="col-md-3">
                                            <input type="checkbox" class="checkbox_child" value="{{ $item->id }}"
                                                name="permission_id[]" id="item-{{ $item->id }}">
                                            <label for="item-{{ $item->id }}">{{ $item->name }}</label>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <input type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">
                </form>
            </div>
        </div>
    </div>
@endsection
