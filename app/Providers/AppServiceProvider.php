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

            $carts = $carts->with(['items.product.shop', 'items.product.productMedia'])
                ->get();

            $carts->each(function ($cart) {
                $cart->items = $cart->items->filter(function ($item) {
                    return $item->product && $item->product->active == 1 && !$item->product->deleted_at;
                });
            });

            $address = Address::where('user_id', Auth::id())->get();

            $view->with('carts', $carts)
                ->with('address', $address)
                ->with('user', $user);
        });
    }
}
