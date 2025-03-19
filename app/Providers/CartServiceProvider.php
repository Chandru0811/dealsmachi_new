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
        $cartnumber = request()->input('cartnumber') ?? session()->get('cartnumber');
        $customer_id = Auth::check() ? Auth::id() : null;

        if ($cartnumber !== null && $customer_id === null) {
            $cart = Cart::where('cart_number', $cartnumber)->first();
        } elseif ($cartnumber !== null && $customer_id !== null) {
            $cart = Cart::where('customer_id', $customer_id)->first();
        } elseif ($cartnumber === null && $customer_id === null) {
            $cart = null;
        } else {
            $cart = Cart::where('customer_id', $customer_id)
                ->orWhere(function ($q) use ($cartnumber) {
                    $q->whereNull('customer_id')
                        ->where('cart_number', $cartnumber);
                })
                ->first();
        }

        if ($cart) {
            $cart->load(['items.product.shop', 'items.product.productMedia:id,resize_path,order,type,imageable_id']);
            $cartItems = $cart->items()
                ->whereHas('product', function ($query) {
                    $query->where('active', 1)
                        ->whereNull('deleted_at');
                })
                ->get();

            $cartItemCount = $cartItems->count();
        } else {
            $cartItems = [];
            $cartItemCount = 0;
        }

        $view->with('cartItems', $cartItems)
            ->with('cartItemCount', $cartItemCount)
            ->with('user', Auth::user())
            ->with('addresses', Address::where('user_id', Auth::id())->get());
    });
}

}
