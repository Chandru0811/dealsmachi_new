<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Address;

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
            $cart = Cart::where('ip_address', request()->ip());
            
            $user = Auth::user();
            
            if (Auth::guard()->check()) {
                $cart = $cart->orWhere('customer_id', Auth::guard()->user()->id);
            }
            
            $cart = $cart->first();
            
            if ($cart) {
                $cartItems = $cart->items()
                    ->whereHas('product', function ($query) {
                        $query->where('active', 1)
                            ->whereNull('deleted_at');
                    })
                    ->get();

                $cartItemCount = $cartItems->count();
                $view->with('cartItems', $cartItems);
                $view->with('cartItemCount', $cartItemCount);
            }else{
                $view->with('cartItems', []);
                $view->with('cartItemCount', 0);
            }
            // dd(Auth::id());
            $address = Address::where('user_id', Auth::id())->get();
            // dd($address);
            $view->with('user', $user)
                ->with('addresses', $address);
        });

        // Event::listen(Login::class, function ($event) {
        //     $cart = Cart::where('ip_address', request()->ip())->first();

        //     if ($cart) {
        //         $cart->customer_id = Auth::id();
        //         $cart->save();
        //     }
        // });
    }
}
