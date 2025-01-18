<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('nav.header', function ($view) {
            $user = Auth::user();

            $carts = Cart::whereNull('customer_id')
                ->where('ip_address', request()->ip());

            if (Auth::check()) {
                $carts = $carts->orWhere('customer_id', Auth::id());
            }

            $carts = $carts->with('items.product.productMedia')->get();

            $address = Address::where('user_id', Auth::id())->get();

            $view->with('carts', $carts)
                ->with('address', $address)
                ->with('user', $user);
        });
    }
}
