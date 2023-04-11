<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\Policies\PostPolicy;
use App\Policies\PagePolicy;
use App\Policies\RolePolicy;
use \App\Models\Role;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\OrderPolicy;
use App\Policies\SliderPolicy;
use App\Policies\BannerPolicy;
use App\Policies\MenuPolicy;
use App\Policies\CategoryProductPolicy;
use App\Policies\CategoryPostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
     '\App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class,
        Page::class => PagePolicy::class,
        \App\Models\Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        Slider::class => SliderPolicy::class,
        Banner::class => BannerPolicy::class,
        Menu::class => MenuPolicy::class,
        CategoryProduct::class => CategoryProductPolicy::class,
        CategoryPost::class => CategoryPostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        // user
        Gate::define('list-user', [UserPolicy::class, 'view']);
        Gate::define('add-user', [UserPolicy::class, 'create']);
        Gate::define('edit-user', [UserPolicy::class, 'update']);
        Gate::define('delete-user', [UserPolicy::class, 'delete']);

        // post
        Gate::define('list-post', [PostPolicy::class, 'view']);
        Gate::define('add-post', [PostPolicy::class, 'create']);
        Gate::define('edit-post', [PostPolicy::class, 'update']);
        Gate::define('delete-post', [PostPolicy::class, 'delete']);

        // page
        Gate::define('list-page', [PagePolicy::class, 'view']);
        Gate::define('add-page', [PagePolicy::class, 'create']);
        Gate::define('edit-page', [PagePolicy::class, 'update']);
        Gate::define('delete-page', [PagePolicy::class, 'delete']);

        // role
        Gate::define('list-role', [RolePolicy::class, 'view']);
        Gate::define('add-role', [RolePolicy::class, 'create']);
        Gate::define('edit-role', [RolePolicy::class, 'update']);
        Gate::define('delete-role', [RolePolicy::class, 'delete']);

        // permission
        Gate::define('list-permission', [PermissionPolicy::class, 'view']);
        Gate::define('add-permission', [PermissionPolicy::class, 'create']);
        Gate::define('edit-permission', [PermissionPolicy::class, 'update']);
        Gate::define('delete-permission', [PermissionPolicy::class, 'delete']);

        // product
        Gate::define('list-product', [ProductPolicy::class, 'view']);
        Gate::define('add-product', [ProductPolicy::class, 'create']);
        Gate::define('edit-product', [ProductPolicy::class, 'update']);
        Gate::define('delete-product', [ProductPolicy::class, 'delete']);

        // order
        Gate::define('list-order', [OrderPolicy::class, 'view']);
        Gate::define('add-order', [OrderPolicy::class, 'create']);
        Gate::define('edit-order', [OrderPolicy::class, 'update']);
        Gate::define('delete-order', [OrderPolicy::class, 'delete']);

        // slider
        Gate::define('list-slider', [SliderPolicy::class, 'view']);
        Gate::define('add-slider', [SliderPolicy::class, 'create']);
        Gate::define('edit-slider', [SliderPolicy::class, 'update']);
        Gate::define('delete-slider', [SliderPolicy::class, 'delete']);

        // banner
        Gate::define('list-banner', [BannerPolicy::class, 'view']);
        Gate::define('add-banner', [BannerPolicy::class, 'create']);
        Gate::define('edit-banner', [BannerPolicy::class, 'update']);
        Gate::define('delete-banner', [BannerPolicy::class, 'delete']);

        // menu
        Gate::define('list-menu', [MenuPolicy::class, 'view']);
        Gate::define('add-menu', [MenuPolicy::class, 'create']);
        Gate::define('edit-menu', [MenuPolicy::class, 'update']);
        Gate::define('delete-menu', [MenuPolicy::class, 'delete']);

        // category-product
        Gate::define('list-category-product', [CategoryProductPolicy::class, 'view']);
        Gate::define('add-category-product', [CategoryProductPolicy::class, 'create']);
        Gate::define('edit-category-product', [CategoryProductPolicy::class, 'update']);
        Gate::define('delete-category-product', [CategoryProductPolicy::class, 'delete']);

        // category-post
        Gate::define('list-category-post', [CategoryPostPolicy::class, 'view']);
        Gate::define('add-category-post', [CategoryPostPolicy::class, 'create']);
        Gate::define('edit-category-post', [CategoryPostPolicy::class, 'update']);
        Gate::define('delete-category-post', [CategoryPostPolicy::class, 'delete']);
    }
}
