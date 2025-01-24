<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;
use App\Models\SavedItem;

class CartController extends Controller
{
    use ApiResponses;

    public function addtoCart(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if(!$product)
        {
            return $this->error('Deal not found!', [], 404);
        }

        $customer_id = Auth::check() ? Auth::user()->id : null;

        if($customer_id)
        {
            $old_cart = Cart::where('customer_id', $customer_id)->orWhere(function($q){
                $q->whereNull('customer_id')->where('ip_address', request()->ip());
            })->first();
        }
        else{
            $old_cart = Cart::whereNull('customer_id')->where('ip_address', $request->ip())->first();
        }

        // Check if the item is alrealy in the cart
        if($old_cart)
        {
            $item_in_cart = CartItem::where('cart_id', $old_cart->id)->where('product_id', $product->id)->first();
            if($item_in_cart)
            {
                return $this->error('Deal Already in Cart!', [], 400);
            }
        }

        $qtt = $request->quantity;
        if($qtt == null)
        {
            $qtt = 1;
        }

        $grand_total = $product->discounted_price * $qtt + $request->shipping + $request->packaging + $request->handling + $request->taxes;

        $discount = ($product->original_price - $product->discounted_price) * $qtt;

        $cart = $old_cart ?? new Cart();
        $cart->customer_id = $customer_id;
        $cart->ip_address = $request->ip();
        $cart->item_count = $old_cart ? ($old_cart->item_count + 1) : 1;
        $cart->quantity = $old_cart ? ($old_cart->quantity + $qtt) : $qtt;
        $cart->total = $old_cart ? ($old_cart->total + ($product->original_price * $qtt)) : ($product->original_price * $qtt);
        $cart->discount = $old_cart ? ($old_cart->discount + $discount) : $discount;
        $cart->shipping = $old_cart ? ($old_cart->shipping + $request->shipping) : $request->shipping;
        $cart->packaging = $old_cart ? ($old_cart->packaging + $request->packaging) : $request->packaging;
        $cart->handling = $old_cart ? ($old_cart->handling + $request->handling) : $request->handling;
        $cart->taxes = $old_cart ? ($old_cart->taxes + $request->taxes) : $request->taxes;
        $cart->grand_total = $old_cart ? ($old_cart->grand_total + $grand_total) : $grand_total;
        $cart->shipping_weight = $old_cart ? ($old_cart->shipping_weight + $request->shipping_weight) : $request->shipping_weight;
        $cart->save();

        $cart_item = new CartItem;
        $cart_item->cart_id = $cart->id;
        $cart_item->product_id = $product->id;
        $cart_item->item_description = $product->name;
        $cart_item->quantity = $qtt;
        $cart_item->unit_price = $product->original_price;
        $cart_item->delivery_date = $request->delivery_date;
        $cart_item->coupon_code = $product->coupon_code;
        $cart_item->discount = $product->discounted_price;
        $cart_item->discount_percent = $product->discount_percentage;
        $cart_item->seller_id = $product->shop_id;
        $cart_item->deal_type = $product->deal_type;
        $cart_item->service_date = $request->service_date;
        $cart_item->service_time = $request->service_time;
        $cart_item->shipping = $request->shipping;
        $cart_item->packaging = $request->packaging;
        $cart_item->handling = $request->handling;
        $cart_item->taxes = $request->taxes;
        $cart_item->shipping_weight = $request->shipping_weight;
        $cart_item->save();

        return $this->success('Deal Added to Cart Successfully!', $cart_item);
    }

    public function getCart(Request $request)
    {
        $carts = Cart::whereNull('customer_id')->where('ip_address', $request->ip());

        if (Auth::guard('api')->check()) {
            $carts = $carts->orWhere('customer_id', Auth::guard('api')->user()->id);
        }

        $carts = $carts->get();

        $carts->load(['items.product.productMedia', 'items.product.shop']);

        return $this->success('Cart Items Retrieved Successfully!', $carts);
    }

    public function updateCart(Request $request)
    {
        $cart = Cart::find($request->cart_id);

        if(!$cart)
        {
            return $this->error('Cart not found!', [], 404);
        }

        $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

        if(!$cart_item)
        {
            return $this->error('Deal not found in cart!', [], 404);
        }

        $qtt = $request->quantity;
        if($qtt == null)
        {
            $qtt = 1;
        }

        $grand_total = $cart_item->discount * $qtt + $cart_item->shipping + $cart_item->packaging + $cart_item->handling + $cart_item->taxes;

        $cart->quantity = $cart->quantity - $cart_item->quantity + $qtt;
        $cart->total = $cart->total - ($cart_item->unit_price * $cart_item->quantity) + ($cart_item->unit_price * $qtt);
        $cart->discount = $cart->discount - (($cart_item->unit_price - $cart_item->discount) * $cart_item->quantity) + (($cart_item->unit_price - $cart_item->discount) * $qtt);
        $cart->shipping = $cart->shipping - $cart_item->shipping + $cart_item->shipping;
        $cart->packaging = $cart->packaging - $cart_item->packaging + $cart_item->packaging;
        $cart->handling = $cart->handling - $cart_item->handling + $cart_item->handling;
        $cart->taxes = $cart->taxes - $cart_item->taxes + $cart_item->taxes;
        $cart->grand_total = $cart->grand_total - (($cart_item->discount * $cart_item->quantity) + $cart_item->shipping + $cart_item->packaging + $cart_item->handling + $cart_item->taxes) + $grand_total;
        $cart->shipping_weight = $cart->shipping_weight - $cart_item->shipping_weight + $cart_item->shipping_weight;
        $cart->save();

        $cart_item->quantity = $qtt;
        $cart_item->service_date = $request->service_date;
        $cart_item->service_time = $request->service_time;
        $cart_item->save();

        return $this->success('Cart Updated Successfully!', $cart_item);
    }

    public function removeItem(Request $request)
    {
        $cart = Cart::find($request->cart_id);

        if(!$cart)
        {
            return $this->error('Cart not found!', [], 404);
        }

        $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

        $cart->item_count = $cart->item_count - 1;
        $cart->quantity = $cart->quantity - $cart_item->quantity;
        $cart->total = $cart->total - ($cart_item->unit_price * $cart_item->quantity);
        $cart->discount = $cart->discount - (($cart_item->unit_price - $cart_item->discount) * $cart_item->quantity);
        $cart->shipping = $cart->shipping - $cart_item->shipping;
        $cart->packaging = $cart->packaging - $cart_item->packaging;
        $cart->handling = $cart->handling - $cart_item->handling;
        $cart->taxes = $cart->taxes - $cart_item->taxes;
        $cart->grand_total = $cart->grand_total - (($cart_item->discount * $cart_item->quantity) + $cart_item->shipping + $cart_item->packaging + $cart_item->handling + $cart_item->taxes);
        $cart->shipping_weight = $cart->shipping_weight - $cart_item->shipping_weight;
        $cart->save();

        $cart_item->delete();

        return $this->success('Deal Removed from Cart Successfully!', $cart_item);
    }

    public function totalItems()
    {
        $customer_id = Auth::check() ? Auth::user()->id : null;

        $cart = Cart::where('customer_id', $customer_id)->orWhere(function($q){
            $q->whereNull('customer_id')->where('ip_address', request()->ip());
        })->first();

        if($cart)
        {
            return $this->success('Total Items in Cart Retrieved Successfully!', $cart->item_count);
        }

        return $this->success('Total Items in Cart Retrieved Successfully!', 0);
    }

    public function saveForLater(Request $request)
    {
        $customer_id = Auth::check() ? Auth::user()->id : null;

        $cart = null;

        if ($customer_id) {
            $cart = Cart::where('customer_id', $customer_id)->first();
        } else {
            $cart = Cart::where(function ($query) {
                $query->whereNull('customer_id')
                ->where('ip_address', request()->ip());
            })->first();
        }

        $cartItem = null;

        if ($cart) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->first();
        }

        if ($cartItem) {
            // Add to Save for Later
            SavedItem::create([
                'user_id' => $customer_id,
                'ip_address' => $request->ip(),
                'deal_id' => $cartItem->product_id,
            ]);

            // Remove from Cart
            $cartItem->delete();

            //update cart
            $cart->item_count = $cart->item_count - 1;
            $cart->quantity = $cart->quantity - $cartItem->quantity;
            $cart->total = $cart->total - ($cartItem->unit_price * $cartItem->quantity);
            $cart->discount = $cart->discount - (($cartItem->unit_price - $cartItem->discount) * $cartItem->quantity);
            $cart->shipping = $cart->shipping - $cartItem->shipping;
            $cart->packaging = $cart->packaging - $cartItem->packaging;
            $cart->handling = $cart->handling - $cartItem->handling;
            $cart->taxes = $cart->taxes - $cartItem->taxes;
            $cart->grand_total = $cart->grand_total - (($cartItem->discount * $cartItem->quantity) + $cartItem->shipping + $cartItem->packaging + $cartItem->handling + $cartItem->taxes);
            $cart->shipping_weight = $cart->shipping_weight - $cartItem->shipping_weight;
            $cart->save();

            return $this->ok('Item moved to Save for Later!');
        }

        return $this->error('Item not found in cart', [], 404);
    }

    public function moveToCart(Request $request)
    {
        $user_id = Auth::check() ? Auth::user()->id : null;

        if(!$user_id)
        {
            $savedItem = SavedItem::where('ip_address', $request->ip())
                ->where('deal_id', $request->product_id)
                ->first();

            $cart = Cart::whereNull('customer_id')->where('ip_address', $request->ip())->first();
        }else{
            $savedItem = SavedItem::where('user_id', $user_id)
                ->where('deal_id', $request->product_id)
                ->first();

            $cart = Cart::where('customer_id', auth('api')->id())->first();
        }

            CartItem::create([
                'cart_id' => $cart->id,
                'item_description' => $savedItem->deal->name,
                'quantity' => 1, // Default quantity
                'unit_price' => $savedItem->deal->original_price,
                'coupon_code' => $savedItem->deal->coupon_code,
                'discount' => $savedItem->deal->discounted_price,
                'discount_percent' => $savedItem->deal->discount_percentage,
                'seller_id' => $savedItem->deal->shop_id,
                'product_id' => $savedItem->deal_id,
                'deal_type' => $savedItem->deal->deal_type,
            ]);

            $savedItem->delete();

            //update cart
            $cart->item_count = $cart->item_count + 1;
            $cart->quantity = $cart->quantity + 1;
            $cart->total = $cart->total + $savedItem->deal->original_price;
            $cart->discount = $cart->discount + ($savedItem->deal->original_price - $savedItem->deal->discounted_price);
            $cart->shipping = $cart->shipping + 0;
            $cart->packaging = $cart->packaging + 0;
            $cart->handling = $cart->handling + 0;
            $cart->taxes = $cart->taxes + 0;
            $cart->grand_total = $cart->grand_total + $savedItem->deal->discounted_price;
            $cart->shipping_weight = $cart->shipping_weight + 0;
            $cart->save();

            return $this->ok('Item moved to Cart');
    }

    public function getsaveforlater()
    {
        $user_id = Auth::check() ? Auth::user()->id : null;

        if(!$user_id){
            $savedItems = SavedItem::where('ip_address', request()->ip())->with('deal.productMedia', 'deal.shop')->get();
        }else{
            $savedItems = SavedItem::where('user_id', $user_id)->with('deal.productMedia', 'deal.shop')->get();
        }

        return $this->success('Item Retrieved from Save for Later!', $savedItems);
    }

    public function removeFromSaveLater(Request $request)
    {
        $user_id = Auth::check() ? Auth::user()->id : null;

        if (!$user_id) {
            $savedItem = SavedItem::where('ip_address', $request->ip())
                ->where('deal_id', $request->product_id)
                ->first();
        } else {
            $savedItem = SavedItem::where('user_id', $user_id)
                ->where('deal_id', $request->product_id)
                ->first();
        }

        if (!$savedItem) {
            return $this->error('Item not found in Save for Later!', [], 404);
        }

        $savedItem->delete();

        return $this->success('Item Removed from Save for Later!', $savedItem);
    }

    public function cartSummary($cart_id, Request $request)
    {
        if (!Auth::check()) {
            return $this->error('User is not authenticated. Redirecting to login.', null, 401);
        } else {
            $user = Auth::user();

            $carts = Cart::where('id', $cart_id)->with(['items.product.productMedia'])->first();

            $addresses = Address::where('user_id', $user->id)->get();

            return $this->success('Cart Summary Details Retrived Successfully',[
                'user'=> $user,
                'carts'=> $carts,
                'addresses'=>$addresses,
            ]);
        }
    }

    public function getCartItem(Request $request)
    {
        $product_ids = $request->input('product_ids');


        if (is_string($product_ids)) {
            $product_ids = json_decode($product_ids, true);
        }
        $products = Product::whereIn('id', $product_ids)->with('shop')->with('productMedia')->get();
        $products = $products->map(function ($product) {
            $image = $product->productMedia->isNotEmpty() ? $product->productMedia->first() : null;
            $product->image = $image ? asset($image->path) : asset('assets/images/home/noImage.webp');
            return $product;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Items Fetched Successfully!',
            'data' => $products,
        ]);
    }
}
