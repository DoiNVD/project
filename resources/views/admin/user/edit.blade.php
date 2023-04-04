@extends('admin.layouts.app')
@section('title')
Sửa User
@endsection
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa người dùng
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/user/update/'.$user->id)}}">
                @csrf
                <div class="form-group">
                    <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email_edit" id="email" disabled value="{{ $user->email }}">
                    <!-- @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif -->
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password" value="">
                    @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password-confirm">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" name="password-confirm" id="password-confirm" value="">
                    @if ($errors->has('password-confirm'))
                    <span class="text-danger">{{ $errors->first('password-confirm') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-strong" for="">Nhóm quyền</label>
                    <select class="select2_init form-control" style="height:200px" name="roles[]" multiple="multiple">
                        <option value=""></option>
                        @foreach ($roles as $role)
                            @if (old('btn-update') !== NULL)
                                <option {{ collect(old('roles'))->contains($role->id) ? 'selected' : '' }}
                                    value="{{ $role->id }}">{{ $role->name }}</option>
                            @else
                                <option {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}
                                    value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit" name="btn-update" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection