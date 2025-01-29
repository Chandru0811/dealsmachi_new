<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class CartServiceProvider extends ServiceProvider
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
        View::composer('*', function ($view) {
            $cartItemCount = 0;

            if (Auth::check()) {
                $cart = Cart::where('customer_id', Auth::id())->first();
            } else {
                $cart = Cart::where('ip_address', request()->ip())->first();
            }

            if ($cart) {
                $cartItemCount = $cart->items()
                    ->whereHas('product', function ($query) {
                        $query->where('active', 1)
                            ->whereNull('deleted_at');
                    })
                    ->count();
            }

            $view->with('cartItemCount', $cartItemCount);
        });

        Event::listen(Login::class, function ($event) {
            $cart = Cart::where('ip_address', request()->ip())->first();

            if ($cart) {
                $cart->customer_id = Auth::id();
                $cart->save();
            }
        });
    }
}
