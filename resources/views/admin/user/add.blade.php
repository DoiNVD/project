@extends('admin.layouts.app')
@section('title')
Thêm mới user
@endsection
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
            Session::forget('success');
            @endphp
        </div>
        @endif
        <div class="card-header font-weight-bold">
            Thêm người dùng
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/user/store')}}">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email">
                    @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password">
                    @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password-confirm">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" name="password-confirm" id="password-confirm">
                    @if ($errors->has('password-confirm'))
                    <span class="text-danger">{{ $errors->first('password-confirm') }}</span>
                    @endif
                </div>
                <div class="form-group">
                        <label class="text-strong" for="">Nhóm quyền</label>
                        <select class="select2_init form-control" style="height:200px" name="roles[]" multiple="multiple">
                            <option value=""></option>
                            @foreach ($roles as $role)
                                <option {{ (collect(old('roles'))->contains($role->id)) ? 'selected':'' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                <button type="submit" name="btn-add" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection