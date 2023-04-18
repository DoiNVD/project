<?php

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminOrderController;

use App\Http\Controllers\Client\MailController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\LocationController;
use App\Http\Controllers\Client\PostController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\VerifiesEmails;
use UniSharp\LaravelFilemanager\Lfm;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//ROUTE PHÍA CLIENT
Route::get('/', [HomeController::class, 'index']);
// ->name('home')->middleware('verified');
//page product
Route::get('/chi-tiet-san-pham/{slug}' . '.html', [ProductController::class, 'detail'])->name('product.detail');
Route::get('/san-pham/{slug}', [App\Http\Controllers\Client\ProductController::class, 'index'])->name('product.cat');
Route::post('/san-pham/tim-kiem-san-pham', [ProductController::class, 'search'])->name('search');
Route::get('/search-product', [ProductController::class, 'result_search'])->name('product.search');

//cart  [CartController::class, 'order_success']
Route::get('cart/add/{id}/{qty?}', [CartController::class, 'add'])->name('cart.add');
Route::get('gio-hang', [CartController::class, 'show'])->name('cart.show');
Route::get('cart/remove/{rowId}',  [CartController::class, 'remove'])->name('cart.remove');
Route::get('cart/destroy', [CartController::class, 'destroy'])->name('cart.destroy');
Route::post('cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::get('thanh-toan',  [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('cart/buy_now/{slug}', [CartController::class, 'buy_now'])->name('cart.buy_now');
Route::post('district', [LocationController::class, 'loadDistrict'])->name('location.district');
Route::post('ward', [LocationController::class, 'loadWard'])->name('location.ward');
Route::post('cart/order', [CartController::class, 'order'])->name('cart.order');
Route::get('dat-hang-thanh-cong', [CartController::class, 'order_success'])->name('order.success');

//post  
Route::get('/24h-cong-nghe' . '.html', [PostController::class, 'index']);
Route::get('/24h-cong-nghe/{slug}' . '.html',  [PostController::class, 'detail'])->name('post.detail');

//page
Route::get('/{slug}.html',  [PageController::class, 'index']);


//Route trình soạn thảo bài viết quản lý file form
Route::group(['prefix' => 'laravel-filemanager'], function () {
  \UniSharp\LaravelFilemanager\Lfm::routes();
});


// ROUTE PHÍA AMIN 
//xác thực sau khi đăng nhập
Auth::routes(['verify' => true]); 
// Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');
// Route::get('/admin/dashboard/index', [DashboardController::class, 'index'])->middleware('auth');
// ->middleware('auth','verified'  );
Route::group([
  'prefix' => 'admin',
  'middleware' => ['auth', 'verified']
], function () {

  Route::get('/dashboard/index', [DashboardController::class, 'index']);
  //user người dùng
  Route::get('user/list', [AdminUserController::class, 'index'])->name('user.list')->middleware('can:list-user');
  Route::get('user/add', [AdminUserController::class, 'create'])->name('user.add')->middleware('can:add-user');;
  Route::post('user/store', [AdminUserController::class, 'store']);
  Route::get('user/edit/{id}', [AdminUserController::class, 'edit'])->name('user.edit')->middleware('can:edit-user');
  Route::post('user/update/{id}', [AdminUserController::class, 'update']);
  Route::get('user/delete/{id}', [AdminUserController::class, 'delete'])->name('delete.user')->middleware('can:delete-user');
  Route::post('user/action', [AdminUserController::class, 'action'])->name('user.action');


  //pages
  Route::get('page/list', [AdminPageController::class, 'index'])->name('page.list')->middleware('can:list-page');
  Route::get('page/add', [AdminPageController::class, 'create'])->name('page.add')->middleware('can:add-page');
  Route::post('page/store', [AdminPageController::class, 'store'])->name('page.store');
  Route::get('page/edit/{id}', [AdminPageController::class, 'edit'])->name('page.edit')->middleware('can:edit-page');
  Route::post('page/update/{id}', [AdminPageController::class, 'update'])->name('page.update');
  Route::get('page/delete/{id}', [AdminPageController::class, 'delete'])->name('page.delete')->middleware('can:delete-page');
  Route::post('page/action', [AdminPageController::class, 'action'])->name('page.action');

  //Slider
  Route::get('slider/list', [AdminSliderController::class, 'index'])->name('slider.list')->middleware('can:list-slider');
  Route::get('slider/add', [AdminSliderController::class, 'create'])->name('slider.add')->middleware('can:add-slider');
  Route::post('slider/store', [AdminSliderController::class, 'store'])->name('slider.store');
  Route::get('slider/edit/{id}', [AdminSliderController::class, 'edit'])->name('slider.edit')->middleware('can:edit-slider');
  Route::post('slider/update/{id}', [AdminSliderController::class, 'update'])->name('slider.update');
  Route::get('slider/delete/{id}', [AdminSliderController::class, 'delete'])->name('slider.delete')->middleware('can:delete-slider');


  //Banner
  Route::get('banner/list', [AdminBannerController::class, 'index'])->name('banner.list')->middleware('can:list-banner');
  Route::get('banner/add', [AdminBannerController::class, 'create'])->name('banner.add')->middleware('can:add-banner');
  Route::post('banner/store', [AdminBannerController::class, 'store'])->name('banner.store');
  Route::get('banner/edit/{id}', [AdminBannerController::class, 'edit'])->name('banner.edit')->middleware('can:edit-banner');
  Route::post('banner/update/{id}', [AdminBannerController::class, 'update'])->name('banner.update');
  Route::get('banner/delete/{id}', [AdminBannerController::class, 'delete'])->name('banner.delete')->middleware('can:delete-banner');

  //Menu
  Route::get('menu/list', [AdminmenuController::class, 'index'])->name('menu.list')->middleware('can:list-menu');
  Route::get('menu/add', [AdminmenuController::class, 'create'])->name('menu.add')->middleware('can:add-menu');
  Route::post('menu/store', [AdminmenuController::class, 'store'])->name('menu.store');
  Route::get('menu/edit/{id}', [AdminmenuController::class, 'edit'])->name('menu.edit')->middleware('can:edit-menu');
  Route::post('menu/update/{id}', [AdminmenuController::class, 'update'])->name('menu.update');
  Route::get('menu/delete/{id}', [AdminmenuController::class, 'delete'])->name('menu.delete')->middleware('can:delete-menu');

  //Post
  Route::get('post/list', [AdminPostController::class, 'index'])->name('post.list')->middleware('can:list-post');
  Route::get('post/add', [AdminPostController::class, 'create'])->name('post.add')->middleware('can:add-post');
  Route::post('post/store', [AdminPostController::class, 'store'])->name('post.store');
  Route::get('post/edit/{id}', [AdminPostController::class, 'edit'])->name('post.edit')->middleware('can:edit-post');
  Route::post('post/update/{id}', [AdminPostController::class, 'update'])->name('post.update');
  Route::get('post/delete/{id}', [AdminPostController::class, 'delete'])->name('post.delete')->middleware('can:delete-post');
  Route::post('post/action', [AdminPostController::class, 'action'])->name('post.action');
  //Post/category/category
  Route::get('post/category/list', [AdminPostController::class, 'index_cat'])->name('post.cat.list')->middleware('can:list-category-post');
  Route::get('post/category/add', [AdminPostController::class, 'create_cat'])->name('post.cat.add')->middleware('can:add-category-post');
  Route::post('post/category/store', [AdminPostController::class, 'store_cat'])->name('post.cat.store');
  Route::get('post/category/edit/{id}', [AdminPostController::class, 'edit_cat'])->name('post.cat.edit')->middleware('can:edit-category-post');
  Route::post('post/category/update/{id}', [AdminPostController::class, 'update_cat_ajax'])->name('post.cat.update');
  Route::get('post/category/delete/{id}', [AdminPostController::class, 'delete_cat_ajax'])->name('post.cat.delete')->middleware('can:delete-category-post');


  //Product
  Route::get('product/list', [AdminProductController::class, 'index'])->name('product.list')->middleware('can:list-product');
  Route::get('product/add', [AdminProductController::class, 'create'])->name('product.add')->middleware('can:add-product');
  Route::post('product/store', [AdminProductController::class, 'store'])->name('product.store');
  Route::get('product/edit/{id}', [AdminProductController::class, 'edit'])->name('product.edit')->middleware('can:edit-product');
  Route::post('product/update/{id}', [AdminProductController::class, 'update'])->name('product.update');
  Route::get('product/delete/{id}', [AdminProductController::class, 'delete'])->name('product.delete')->middleware('can:delete-product');
  Route::post('product/action', [AdminProductController::class, 'action'])->name('product.action');
  Route::get('product/delete_image/{id}', [AdminProductController::class, 'delete_image_child'])->name('product.delete_image_child');
  //Product/category/category
  Route::get('product/category/list', [AdminProductController::class, 'index_cat'])->name('product.cat.list')->middleware('can:list-category-product');
  Route::get('product/category/add', [AdminProductController::class, 'create_cat'])->name('product.cat.add')->middleware('can:add-category-product');
  Route::post('product/category/store', [AdminProductController::class, 'store_cat'])->name('product.cat.store');
  Route::get('product/category/edit/{id}', [AdminProductController::class, 'edit_cat'])->name('product.cat.edit')->middleware('can:edit-category-product');
  Route::post('product/category/update/{id}', [AdminProductController::class, 'update_cat'])->name('product.cat.update');
  Route::get('product/category/delete/{id}', [AdminProductController::class, 'delete_cat'])->name('product.cat.delete')->middleware('can:delete-category-product');



  //Role vai trò user
  Route::get('role/list', [AdminRoleController::class, 'index'])->name('role.list')->middleware('can:list-role');
  Route::get('role/add', [AdminRoleController::class, 'create'])->name('role.add')->middleware('can:add-role');
  Route::post('role/store', [AdminRoleController::class, 'store'])->name('role.store');
  Route::get('role/edit/{id}', [AdminRoleController::class, 'edit'])->name('role.edit')->middleware('can:edit-role');
  Route::post('role/update/{id}', [AdminRoleController::class, 'update'])->name('role.update');
  Route::get('role/delete/{id}', [AdminRoleController::class, 'delete'])->name('role.delete')->middleware('can:delete-role');


  //permission Cấp quyền user
  Route::get('permission/list', [AdminPermissionController::class, 'index'])->name('permission.list')->middleware('can:list-permission');
  Route::get('permission/add', [AdminPermissionController::class, 'create'])->name('permission.add')->middleware('can:add-permission');
  Route::post('permission/store', [AdminPermissionController::class, 'store'])->name('permission.store');
  Route::get('permission/edit/{id}', [AdminPermissionController::class, 'edit'])->name('permission.edit')->middleware('can:edit-permission');
  Route::post('permission/update/{id}', [AdminPermissionController::class, 'update'])->name('permission.update');
  Route::get('permission/delete/{id}', [AdminPermissionController::class, 'delete'])->name('permission.delete')->middleware('can:delete-permission');

  //Order
  Route::get('order/list',  [AdminOrderController::class, 'list'])->name('order.list')->middleware('can:list-order');
  Route::get('order/detail/{order_code}', [AdminOrderController::class, 'detail'])->name('order.detail')->middleware('can:edit-order');
  Route::post('order/update/{order_code}',  [AdminOrderController::class, 'update'])->name('order.update');
  Route::get('order/delete/{order_code}', [AdminOrderController::class, 'delete'])->name('order.delete')->middleware('can:delete-order');
  Route::post('order/action',   [AdminOrderController::class, 'action'])->name('order.action');
});

Route::get('/mail', [MailController::class, 'sendmail']);



