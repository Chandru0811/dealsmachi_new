<?php

namespace App\Providers;

use App\Helpers\CartHelper;
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

            $carts = Cart::where('ip_address', request()->ip());

            if (Auth::check()) {
                $carts = $carts->orWhere('customer_id', Auth::id());
            }

            $carts = $carts->with(['items.product.shop', 'items.product.productMedia'])
                ->get();

            // Cleanup invalid items for each cart
            $carts->each(function ($cart) {
                CartHelper::cleanUpCart($cart);
            });

            $address = Address::where('user_id', Auth::id())->get();

            $view->with('carts', $carts)
                ->with('address', $address)
                ->with('user', $user);
        });
    }
}
