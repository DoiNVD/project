@php
$module_active=session()->get('module_active');
@endphp
<div id="sidebar" class="bg-white">
    <ul id="sidebar-menu">
        <li class="nav-link  {{$module_active=='Dashboard'?'active':''}}">
            <!-- Biểu thức điều kiện rút gọn $var = BTĐK?Giá trị 1: Giá trị 2 -->
            <a href="{{url('admin/dashboard/index')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                <span class="title">Dashboard</span>
                <i class="arrow fas fa-angle-right"></i>
            </a>

        </li>
        @canany(['list-page', 'add-page', 'edit-page', 'delete-page'])
        <li class="nav-link {{$module_active=='page'?'active':''}}">
            <a href="{{url('admin/page/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Trang
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                @can('add-page')
                <li><a href="{{url('admin/page/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/page/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['list-slider', 'add-slider', 'edit-slider', 'delete-slider'])
        <li class="nav-link {{$module_active=='slider'?'active':''}}">
            <a href="{{url('admin/slider/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Slider
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                @can('add-slider')
                <li><a href="{{url('admin/slider/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/slider/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['list-banner', 'add-banner', 'edit-banner', 'delete-banner'])
        <li class="nav-link {{$module_active=='banner'?'active':''}}">
            <a href="{{url('admin/banner/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Banner
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                @can('add-banner')
                <li><a href="{{url('admin/banner/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/banner/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['list-menu', 'add-menu', 'edit-menu', 'delete-menu'])
        <li class="nav-link {{ $module_active == 'menu' ? 'active' : '' }}">
            <a href="{{url('admin/menu/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Menu
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                @can('add-menu')
                <li><a href="{{url('admin/menu/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/menu/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['list-post', 'add-post', 'edit-post', 'delete-post'])
        <li class="nav-link  {{$module_active=='post'?'active':''}}">
            <a href="{{url('admin/post/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Bài viết
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                @can('add-post')
                <li><a href="{{url('admin/post/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/post/list')}}">Danh sách</a></li>
                @canany(['list-category-post', 'add-category-post', 'edit-category-post', 'delete-category-post'])
                <li ><a href="{{url('admin/post/category/list')}} ">Danh mục</a></li>
                @endcanany
            </ul>
        </li>
        @endcanany
        @canany(['list-product', 'add-product', 'edit-product', 'delete-product'])
        <li class="nav-link  {{$module_active=='product'?'active':''}}">
            <a href="{{url('admin/product/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Sản phẩm
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <ul class="sub-menu">
                @can('add-product')
                <li><a href="{{url('admin/product/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/product/list')}}">Danh sách</a></li>
                @canany(['list-category-product', 'add-category-product', 'edit-category-product', 'delete-category-product'])
                <li><a href="{{url('admin/product/category/list')}}">Danh mục</a></li>
                @endcanany
            </ul>
        </li>
        @endcanany
        @canany(['list-order', 'edit-order', 'delete-order'])
        <li class="nav-link    {{$module_active=='user'?'order':''}}">
            <a href="{{url('admin/order/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Đơn hàng
            </a>
            <i class="arrow fas fa-angle-right"></i>
            <!-- <ul class="sub-menu">
                <li><a href="{{url('admin/order/list')}}">Đơn hàng</a></li>
            </ul> -->
        </li>
        @endcanany
        @canany(['list-user', 'add-user', 'edit-user', 'delete-user'])
        <li class="nav-link    {{$module_active=='user'?'active':''}}">
            <a href="{{url('admin/user/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Users
            </a>
            <i class="arrow fas fa-angle-right"></i>

            <ul class="sub-menu">
                @can('add-user')
                <li><a href="{{url('admin/user/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/user/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['list-permission', 'add-permission', 'edit-permission', 'delete-permission'])
        <li class="nav-link    {{$module_active=='permission'?'active':''}}">
            <!-- Biểu thức điều kiện rút gọn $var = BTĐK?Giá trị 1: Giá trị 2 -->
            <a href="{{url('admin/permission/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Danh sách các quyền
            </a>
            <i class="arrow fas fa-angle-right"></i>

            <ul class="sub-menu">
                @can('add-permission')
                <li><a href="{{url('admin/permission/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/permission/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
        @canany(['list-role', 'add-role', 'edit-role', 'delete-role'])
        <li class="nav-link    {{$module_active=='role'?'active':''}}">
            <!-- Biểu thức điều kiện rút gọn $var = BTĐK?Giá trị 1: Giá trị 2 -->
            <a href="{{url('admin/role/list')}}">
                <div class="nav-link-icon d-inline-flex">
                    <i class="far fa-folder"></i>
                </div>
                Danh sách các vai trò
            </a>
            <i class="arrow fas fa-angle-right"></i>

            <ul class="sub-menu">
                @can('add-role')
                <li><a href="{{url('admin/role/add')}}">Thêm mới</a></li>
                @endcan
                <li><a href="{{url('admin/role/list')}}">Danh sách</a></li>
            </ul>
        </li>
        @endcanany
    </ul>
</div>