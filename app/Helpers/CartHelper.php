<?php

namespace App\Helpers;

use App\Models\Cart;

class CartHelper
{
    /**
     * Cleans up inactive or deleted items from the cart.
     *
     * @param Cart $cart
     * @return void
     */
    public static function cleanUpCart(Cart $cart)
    {
        $itemsToRemove = $cart->items->filter(function ($item) {
            return !$item->product || $item->product->active != 1 || $item->product->deleted_at != null;
        });

        if ($itemsToRemove->isNotEmpty()) {
            foreach ($itemsToRemove as $item) {
                $cart->item_count -= 1;
                $cart->quantity -= $item->quantity;
                $cart->total -= ($item->unit_price * $item->quantity);
                $cart->discount -= (($item->unit_price - $item->discount) * $item->quantity);
                $cart->shipping -= $item->shipping;
                $cart->packaging -= $item->packaging;
                $cart->handling -= $item->handling;
                $cart->taxes -= $item->taxes;
                $cart->grand_total -= (($item->discount * $item->quantity) + $item->shipping + $item->packaging + $item->handling + $item->taxes);
                $cart->shipping_weight -= $item->shipping_weight;

                $item->delete(); // Remove the item from the cart
            }

            $cart->save(); // Update the cart totals
        }
    }
}
