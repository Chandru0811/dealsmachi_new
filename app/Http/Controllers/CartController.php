<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\SavedItem;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::whereNull('customer_id')->where('ip_address', $request->ip());

        if (Auth::guard()->check()) {
            $carts = $carts->orWhere('customer_id', Auth::guard()->user()->id);
        }

        $carts = $carts->get();

        $bookmarkedProducts = collect();

        if (Auth::check()) {
            $userId = Auth::id();
            $bookmarkedProducts = Bookmark::where('user_id', $userId)->pluck('deal_id');
        } else {
            $ipAddress = $request->ip();
            $bookmarkedProducts = Bookmark::where('ip_address', $ipAddress)->pluck('deal_id');
        }

        $carts->load(['items.product.shop', 'items.product.productMedia'])
            ->each(function ($cart) {
                $cart->items = $cart->items->filter(function ($item) {
                    return $item->product && $item->product->active == 1 && !$item->product->deleted_at;
                });
            });

        $savedItems = collect();

        $user_id = Auth::check() ? Auth::user()->id : null;

        if (!$user_id) {
            $savedItems = SavedItem::where('ip_address', $request->ip())->with('deal.productMedia', 'deal.shop')->get();
        } else {
            $savedItems = SavedItem::where('user_id', $user_id)->with('deal.productMedia', 'deal.shop')->get();
        }

        return view('cart', compact('carts', 'bookmarkedProducts', 'savedItems'));
    }

    public function addToCart(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return response()->json(['error' => 'Deal not found!'], 404);
        }

        $customer_id = Auth::check() ? Auth::user()->id : null;

        if ($customer_id) {
            $old_cart = Cart::where(function ($query) use ($customer_id) {
                $query->where('customer_id', $customer_id)
                    ->orWhere(function ($q) {
                        $q->whereNull('customer_id')->where('ip_address', request()->ip());
                    });
            })->first();
        } else {
            $old_cart = Cart::where('ip_address', $request->ip())->first();
        }

        // Check if the item is alrealy in the cart
        if ($old_cart) {
            $item_in_cart = CartItem::where('cart_id', $old_cart->id)->where('product_id', $product->id)->first();
            if ($item_in_cart && $request->saveoption == "buy now") {
                return redirect()->route('checkout.summary', $product->id);
            } elseif ($item_in_cart) {
                return response()->json(['error' => 'Deal already in cart!'], 400);
            }
        }

        $qtt = $request->quantity;
        if ($qtt == null) {
            $qtt = 1;
        }
        $payment_status = $request->payment_status;
        if ($payment_status == null) {
            $payment_status = 1;
        }

        $grand_total = $product->discounted_price * $qtt + $request->shipping + $request->packaging + $request->handling + $request->taxes;

        $discount = ($product->original_price - $product->discounted_price) * $qtt;

        $cart = $old_cart ?? new Cart;
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

        $cartItemCount = CartItem::where('cart_id', $cart->id)->sum('quantity');

        if ($request->saveoption == "buy now") {
            return redirect()->route('checkout.summary', $product->id);
        } else {
            return response()->json([
                'status' => 'Deal added to cart!',
                'cartItemCount' => $cartItemCount
            ]);
        }
    }

    public function updateCart(Request $request)
    {
        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found!',
                'redirect' => url()->previous(),
            ], 404);
        }

        $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

        if (!$cart_item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Deal not found in cart!',
                'redirect' => url()->previous(),
            ], 404);
        }

        $qtt = $request->quantity;

        if ($qtt == null) {
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
        if ($request->service_date) {
            $cart_item->service_date = $request->service_date;
        }
        if ($request->service_time) {
            $cart_item->service_time = $request->service_time;
        }
        $cart_item->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cart Updated Successfully!',
            'redirect' => url()->previous(),
            'updatedCart' => [
                'quantity' => $cart->quantity,
                'subtotal' => $cart->total,
                'discount' => $cart->discount,
                'grand_total' => $cart->grand_total,
            ],
        ]);
    }

    public function removeItem(Request $request)
    {
        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart not found!');
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

        return redirect()->back()->with('status', 'Deal Removed from Cart!');
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

            return redirect()->back()->with(['status' => 'Item moved to Save for Later'], 200);
        }

        return redirect()->back()->with(['status' => 'Item not found in cart'], 401);
    }

    public function moveToCart(Request $request)
    {
        $user_id = Auth::check() ? Auth::user()->id : null;

        if (!$user_id) {
            $savedItem = SavedItem::where('ip_address', $request->ip())
                ->where('deal_id', $request->product_id)
                ->first();

            $cart = Cart::whereNull('customer_id')->where('ip_address', $request->ip())->first();
        } else {
            $savedItem = SavedItem::where('user_id', $user_id)
                ->where('deal_id', $request->product_id)
                ->first();

            $cart = Cart::where('customer_id', $user_id)->first();
        }
        if (!$cart) {
            return redirect()->back()->with(['status' => 'No cart found'], 404);
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

        return redirect()->back()->with(['status' => 'Item moved to Cart'], 200);
    }

    // public function multipleMoveToCart(Request $request)
    // {
    //     // dd($request->all());
    //     $customer_id = Auth::id();
    //     $deal_ids = $request->input('deal_ids', []);

    //     if (empty($deal_ids)) {
    //         return response()->json(['status' => 'error', 'message' => 'No items selected to move.'], 400);
    //     }

    //     $cart = Cart::firstOrCreate(
    //         ['customer_id' => $customer_id, 'ip_address' => $request->ip()],
    //         ['item_count' => 0, 'quantity' => 0, 'total' => 0, 'discount' => 0, 'grand_total' => 0]
    //     );

    //     foreach ($deal_ids as $deal_id) {
    //         $savedItem = SavedItem::where('deal_id', $deal_id)
    //             ->where(function ($query) use ($customer_id) {
    //                 $query->where('user_id', $customer_id)
    //                     ->orWhere('ip_address', request()->ip());
    //             })
    //             ->first();

    //         if ($savedItem) {
    //             $deal = $savedItem->deal;
    //             // dd($deal);
    //             CartItem::updateOrCreate(
    //                 ['cart_id' => $cart->id, 'product_id' => $deal_id],
    //                 [
    //                     'item_description' => $deal->name,
    //                     'seller_id' => $deal->shop_id,
    //                     'deal_type' => $deal->deal_type,
    //                     'quantity' => 1,
    //                     'unit_price' => $deal->original_price,
    //                     'discount' => $deal->discount,
    //                     'delivery_date' => "2025-04-11",
    //                     'coupon_code' => $deal->coupon_code,
    //                     'discount' => $deal->discounted_price,
    //                     'discount_percent' => $deal->discount_percent,
    //                     'discount' => $deal->discounted_price,
    //                     'discount' => $deal->discounted_price,
    //                     'taxes' => 0
    //                 ]
    //             );

    //             // Remove the item from the "Save for Later" list
    //             $savedItem->delete();
    //         }
    //     }

    //     // Update cart totals
    //     $cart->updateCartTotals();

    //     return response()->json(['status' => 'success', 'message' => 'Selected items have been moved to the cart.']);
    // }

    public function getsaveforlater()
    {
        $user_id = Auth::check() ? Auth::user()->id : null;

        if (!$user_id) {
            $savedItems = SavedItem::where('ip_address', request()->ip())
                ->whereHas('deal', function ($query) {
                    $query->where('active', 1)->whereNull('deleted_at');
                })
                ->with('deal.productMedia', 'deal.shop')
                ->get();
        } else {
            $savedItems = SavedItem::where('user_id', $user_id)
                ->whereHas('deal', function ($query) {
                    $query->where('active', 1)->whereNull('deleted_at');
                })
                ->with('deal.productMedia', 'deal.shop')
                ->get();
        }
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
            return redirect()->back()->with(['status' => 'Item not found in Save for Later'], 404);
        }

        $savedItem->delete();

        return redirect()->back()->with(['status' => 'Item removed from Save for Later'], 200);
    }

    public function cartSummary($cart_id, Request $request)
    {
        if (!Auth::check()) {
            session(['url.intended' => route('cart.address')]);
            return redirect()->route("login");
        } else {
            $user = Auth::user();
            $carts = Cart::where('id', $cart_id)->with(['items'])->first();
            $addresses = Address::where('user_id', $user->id)->get();
            return view('cartsummary', compact('carts', 'user', 'addresses'));
        }
    }

    public function getCartItem(Request $request)
    {
        $product_ids = $request->input('product_ids');

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
