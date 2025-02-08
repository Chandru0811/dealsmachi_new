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

            if (Auth::guard()->check()) {
                $carts = $carts->orWhere('customer_id', Auth::guard()->user()->id)->first();
            }
            
            if ($carts) {
                $carts = $carts->with(relations: ['items.product.shop', 'items.product.productMedia:id,resize_path,order,type,imageable_id'])
                    ->first();
                    
                // Cleanup invalid items for each cart
                CartHelper::cleanUpCart($carts);
                
                $address = Address::where('user_id', Auth::id())->get();
    
                $view->with('carts', $carts)
                    ->with('address', $address)
                    ->with('user', $user);
                }else{
                    $address = Address::where('user_id', Auth::id())->get();

                    $view->with('carts', null)
                        ->with('address', $address)
                        ->with('user', $user);
                }
        });
    }
}
