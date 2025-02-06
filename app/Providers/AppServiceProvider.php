<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Config;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        View::composer('admin.partials.sidebar', function ($view) {
            View::share('shared_orders_count', Order::count());
            
        });
        View::composer('partials.header', function ($view) {
            View::share('shared_catalogues', Catalogue::orderBy('id','asc')->get());
            
        });
        View::composer(['contact.index','partials.*', 'layouts.*', 'home.*', 'contact.advise'], function ($view) {
            View::share('shared_config', Config::all()->keyBy('name'));
            
        });
        View::composer(['home.*','partials.header'], function ($view) {
            View::share('shared_categories', Category::orderBy('id','asc')->get());
            
        });
    }
}
