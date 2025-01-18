<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\SavedItem;
use App\Models\Shop;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function directcheckout($id, Request $request)
    {
        if (!Auth::check()) {
            session(['url.intended' => route('checkout.direct')]);
            return redirect()->route("login");
        } else {
            $user = Auth::user();
            $product = Product::with(['shop'])->where('id', $id)->where('active', 1)->first();
            if (!$product) {
                return redirect()->route('home')->with('error', 'Product not found or inactive.');
            }
            $order = Order::where('customer_id', $user->id)->orderBy('id', 'desc')->first();
            return view('checkout', compact('product', 'user', 'order'));
        }
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required|string|max:200',
            'email'             => 'required|email|max:200',
            'mobile'            => 'required|string|max:15',
            'order_type'        => 'required|string|max:50',
            'payment_type'      => 'required|string|max:50',
            'street'            => 'required|string',
            'city'              => 'required|string',
            'state'             => 'required|string',
            'country'           => 'required|string',
            'zipCode'           => 'required|string',
            'product_id'        => 'required|integer'
        ], [
            'first_name.required'    => 'Please provide your first name.',
            'first_name.string'      => 'First name must be a valid text.',
            'first_name.max'         => 'First name may not exceed 200 characters.',
            'email.required'         => 'Please provide an email address.',
            'email.email'            => 'Please provide a valid email address.',
            'email.max'              => 'Email may not exceed 200 characters.',
            'mobile.required'        => 'Please provide a mobile number.',
            'mobile.string'          => 'Mobile number must be a valid text.',
            'mobile.max'             => 'Mobile number may not exceed 15 characters.',
            'order_type.required'    => 'Please specify the order type.',
            'order_type.string'      => 'Order type must be a valid text.',
            'order_type.max'         => 'Order type may not exceed 50 characters.',
            'payment_type.required'  => 'Please specify the payment type.',
            'payment_type.string'    => 'Payment type must be a valid text.',
            'payment_type.max'       => 'Payment type may not exceed 50 characters.',
            'product_id.required'    => 'Product ID is required.',
            'product_id.integer'     => 'Product ID must be a valid integer.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $address = [
            'street' => $request->input('street'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'zipCode' => $request->input('zipCode'),
        ];
        $user_id = Auth::check() ? Auth::id() : null;
        $product = Product::with(['shop'])->where('id', $request->input('product_id'))->where('active', 1)->first();
        $latestOrder = Order::orderBy('id', 'desc')->first();
        $customOrderId = $latestOrder ? intval(Str::after($latestOrder->id, '-')) + 1 : 1;
        $orderNumber = 'DEALSMACHI_O' . $customOrderId;

        $order = Order::create([
            'order_number'     => $orderNumber,
            'customer_id'      => $user_id,
            'shop_id'          => $product->shop_id,
            'first_name'       => $request->input('first_name'),
            'last_name'        => $request->input('last_name'),
            'email'            => $request->input('email'),
            'mobile'           => $request->input('mobile'),
            'order_type'       => $request->input('order_type'),
            'status'           => 1, //created
            'notes'            => $request->input('notes') ?? null,
            'payment_type'     => $request->input('payment_type'),
            'payment_status'   => $request->input('payment_status') ?? "1",
            'total'            => $request->input('total'),
            'service_date'     => $request->input('service_date') ?? null,
            'service_time'     => $request->input('service_time') ?? null,
            'quantity'         => $request->input('quantity') ?? 1,
            'delivery_address' => json_encode($address),
            'coupon_applied'   => $request->input('coupon_applied') ?? false,
        ]);

        if ($order) {
            OrderItems::create([
                'order_id'         => $order->id,
                'deal_id'       => $product->id,
                'deal_name'         => $product->name,
                'deal_originalprice' => $product->original_price,
                'deal_description' => $product->description ?? null,
                'quantity'         => $request->input('quantity') ?? 1,
                'deal_price'       => $product['discounted_price'],
                'discount_percentage' => $product->discount_percentage,
                'coupon_code' => $product->coupon_code
            ]);
        }

        $statusMessage = $request->input('order_type') == 'Product'
            ? 'Order Created Successfully!'
            : 'Service Booked Successfully!';

        $shop = Shop::where('id', $product->shop_id)->first();
        $customer = User::where('id', $user_id)->first();
        $orderdetails = Order::where('id', $order->id)->with(['items'])->first();

        Mail::to($shop->email)->send(new OrderCreated($shop, $customer, $orderdetails));

        return redirect()->route('customer.orderById', ['id' => $order->id])->with('status', $statusMessage);
    }

    public function getAllOrdersByCustomer()
    {
        $customerId = Auth::check() ? Auth::id() : null;

        $orders = Order::where('customer_id', $customerId)
            ->with([
                'items.product' => function ($query) {
                    $query->select('id', 'name', 'description', 'original_price', 'discounted_price', 'discount_percentage')->with('productMedia');
                },
                'shop' => function ($query) {
                    $query->select('id', 'name');
                },
                'customer' => function ($query) {
                    $query->select('id', 'name');
                }
            ])
            ->get();
        // dd($orders);
        return view('orders', compact('orders'));
    }

    public function showOrderByCustomerId($id)
    {
        $order = Order::with(['items.product', 'shop', 'customer',])->find($id);

        if (!$order || Auth::id() !== $order->customer_id) {
            return view('orderView', ['order' => null]);
        }

        return view('orderView', compact('order'));
    }

    public function orderInvoice($id)
    {
        $order = Order::with('items', 'shop')->find($id);

        if (!$order || Auth::id() !== $order->customer_id) {
            return redirect()->route('orders')->with('error', 'Order not found or unauthorized access.');
        }

        $logoPath = public_path('assets/images/home/header-logo.webp');
        $logoBase64 = null;

        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        } else {
            $logoBase64 = 'https://dealsmachi.com/assets/images/home/header-logo.webp';
        }

        $data = [
            'order' => $order,
            'items' => $order->items,
            'shop' => $order->shop,
            'logo' => $logoBase64,
        ];

        $pdf = Pdf::loadView('orderinvoice', $data)->setOptions(['isRemoteEnabled' => true]);

        $fileName = $order->order_number . '.pdf';
        return $pdf->download($fileName);
    }

    public function checkoutsummary($id, Request $request)
    {
        if (!Auth::check()) {
            session(['url.intended' => route('checkout.summary')]);
            return redirect()->route("login");
        } else {
            $user = Auth::user();
            $products = Product::with(['shop'])->where('id', $id)->where('active', 1)->get();
            // dd($products);

            if (!$products) {
                return redirect()->route('home')->with('error', 'Product not found or inactive.');
            }

            $carts = Cart::whereNull('customer_id')->where('ip_address', $request->ip());

            if (Auth::guard()->check()) {
                $carts = $carts->orWhere('customer_id', Auth::guard()->user()->id);
            }

            $carts = $carts->first();
            if ($carts) {
                $carts->load(['items' => function ($query) use ($id) {
                    $query->where('product_id', '!=', $id);
                }, 'items.product.shop']);
            }

            $savedItem = SavedItem::whereNull('user_id')->where('ip_address', $request->ip());

            if (Auth::guard()->check()) {
                $savedItem = $savedItem->orWhere('user_id', Auth::guard()->user()->id);
            }

            $savedItem = $savedItem->get();
            $savedItem->load(['deal']);

            $addresses = Address::where('user_id', $user->id)->get();
            // $order = Order::where('customer_id', $user->id)->orderBy('id', 'desc')->first();
            // dd($address);
            return view('summary', compact('products', 'user', 'carts', 'addresses', 'savedItem'));
        }
    }

    public function cartcheckout($cart_id, Request $request)
    {
        $address_id = $request->address_id;

        $address = Address::where('id', $address_id)->first();
        // dd($address);
        $cart = Cart::where('id', $cart_id)->with('items')->first();
        if (!$cart) {
            return redirect()->route('home')->with('error', 'Cart not found.');
        }

        if (!Auth::check()) {
            session(['url.intended' => route('checkout.cart', ['cart_id' => $cart_id])]);
            return redirect()->route("login");
        } else {
            $user = Auth::user();
            $order = Order::where('customer_id', $user->id)->orderBy('id', 'desc')->first();
            $orderoption = 'cart';
            return view('checkout', compact('cart', 'user', 'address', 'order', 'orderoption'));
        }
    }

    public function createorder(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'payment_type'      => 'required|string|max:50',
            'address_id'        => 'required|integer',
            'cart_id'           => 'required_without:product_id|integer',
            'product_id'        => 'required_without:cart_id|integer'
        ], [
            'payment_type.required'      => 'Payment Type is required.',
            'payment_type.string'        => 'Payment Type must be a valid text.',
            'payment_type.max'           => 'Payment Type may not exceed 50 characters.',
            'address_id.required'        => 'Address ID is required.',
            'address_id.integer'         => 'Address ID must be a valid number.',
            'cart_id.required_without'   => 'Cart ID is required when Product ID is not provided.',
            'cart_id.integer'            => 'Cart ID must be a valid number.',
            'product_id.required_without' => 'Product ID is required when Cart ID is not provided.',
            'product_id.integer'         => 'Product ID must be a valid number.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_id = Auth::check() ? Auth::id() : null;
        $cart_id = $request->input('cart_id');
        $product_ids = $request->input('product_ids');
        // dd($product_ids);
        if ($product_ids != null) {


            // Handle single product order
            $product = Product::with(['shop'])->where('id', $product_id)->where('active', 1)->first();
            if (!$product) {
                return redirect()->route('home')->with('error', 'Product not found or inactive.');
            }

            $cartItem = CartItem::where('product_id', $product_id)->first();
            if ($cartItem) {
                $latestOrder = Order::orderBy('id', 'desc')->first();
                $customOrderId = $latestOrder ? intval(Str::after($latestOrder->id, '-')) + 1 : 1;
                $orderNumber = 'DEALSLAH_O' . $customOrderId;

                $order = Order::create([
                    'order_number'     => $orderNumber,
                    'customer_id'      => $user_id,
                    'address_id'       => $request->address_id,
                    'item_count'       => 1,
                    'quantity'         => $cartItem->quantity,
                    'total'            => $cartItem->unit_price,
                    'discount'         => $cartItem->discount,
                    'shipping'         => $cartItem->shipping,
                    'packaging'        => $cartItem->packaging,
                    'handling'         => $cartItem->handling,
                    'taxes'            => $cartItem->taxes,
                    'grand_total'      => $cartItem->unit_price + $cartItem->shipping + $cartItem->packaging + $cartItem->handling + $cartItem->taxes,
                    'shipping_weight'  => $cartItem->shipping_weight,
                    'payment_type'     => $request->input('payment_type'),
                    'payment_status'   => 1,
                ]);

                $order_items = [
                    'order_id'         => $order->id,
                    'product_id'       => $product_id,
                    'seller_id'        => $product->shop_id,
                    'item_description' => $product->name,
                    'quantity'         => $cartItem->quantity,
                    'unit_price'       => $cartItem->unit_price,
                    'delivery_date'    => $cartItem->delivery_date,
                    'coupon_code'      => $cartItem->coupon_code,
                    'discount'         => $cartItem->discount,
                    'discount_percent' => $cartItem->discount_percent,
                    'deal_type'        => $cartItem->deal_type,
                    'service_date'     => $cartItem->service_date,
                    'service_time'     => $cartItem->service_time,
                    'shipping'         => $cartItem->shipping ?? 0,
                    'packaging'        => $cartItem->packaging ?? 0,
                    'handling'         => $cartItem->handling ?? 0,
                    'taxes'            => $cartItem->taxes ?? 0,
                    'shipping_weight'  => $cartItem->shipping_weight ?? 0
                ];

                $order_items = OrderItems::create($order_items);

                $cart = Cart::where('id', $cartItem->cart_id)->first();

                //update cart
                $cartItem->delete();
                $cart->item_count = $cart->item_count - 1;
                $cart->quantity = $cart->quantity - $cartItem->quantity;
                $cart->total = $cart->total - ($cartItem->unit_price * $cartItem->quantity);
                $cart->discount = $cart->discount - ($cartItem->discount * $cartItem->quantity);
                $cart->shipping = $cart->shipping - $cartItem->shipping;
                $cart->packaging = $cart->packaging - $cartItem->packaging;
                $cart->handling = $cart->handling - $cartItem->handling;
                $cart->taxes = $cart->taxes - $cartItem->taxes;
                $cart->grand_total = $cart->grand_total - ($cartItem->unit_price + $cartItem->shipping + $cartItem->packaging + $cartItem->handling + $cartItem->taxes);
                $cart->shipping_weight = $cart->shipping_weight - $cartItem->shipping_weight;
                $cart->save();
            }
        } elseif ($cart_id != null && $product_ids == null) {
            // Handle cart order
            $cart = Cart::with('items')->where('id', $cart_id)->first();
            if (!$cart) {
                return redirect()->route('home')->with('error', 'Cart not found.');
            }

            // Create order for the cart items
            $latestOrder = Order::orderBy('id', 'desc')->first();
            $customOrderId = $latestOrder ? intval(Str::after($latestOrder->id, '-')) + 1 : 1;
            $orderNumber = 'DEALSLAH_O' . $customOrderId;

            $order = Order::create([
                'order_number'     => $orderNumber,
                'customer_id'      => $user_id,
                'item_count'       => $cart->item_count ?? "0",
                'quantity'         => $cart->quantity,
                'total'            => $cart->total,
                'discount'         => $cart->discount,
                'shipping'         => $cart->shipping,
                'packaging'        => $cart->packaging,
                'handling'         => $cart->handling,
                'taxes'            => $cart->taxes,
                'grand_total'      => $cart->grand_total,
                'shipping_weight'  => $cart->shipping_weight,
                'payment_type'     => $request->input('payment_type'),
                'payment_status'   => 1,
                'address_id'       => $request->address_id
            ]);

            foreach ($cart->items as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'seller_id' => $item->product->shop_id,
                    'item_description' => $item->item_description,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'delivery_date' => $item->delivery_date,
                    'coupon_code' => $item->coupon_code,
                    'discount' => $item->discount,
                    'discount_percent' => $item->discount_percent,
                    'deal_type' => $item->deal_type,
                    'service_date' => $item->service_date,
                    'service_time' => $item->service_time,
                    'shipping' => $item->shipping ?? 0,
                    'packaging' => $item->packaging ?? 0,
                    'handling' => $item->handling ?? 0,
                    'taxes' => $item->taxes ?? 0,
                    'shipping_weight' => $item->shipping_weight ?? 0,
                ]);
            }
            // Delete cart and cart items
            $cart->items()->delete();
            $cart->delete();
        } else {
            return redirect()->route('home')->with('error', 'Invalid request.');
        }

        // $shop = Shop::where('id',$product->shop_id)->first();
        //$customer = User::where('id', $user_id)->first();
        //$orderdetails = Order::where('id', $order->id)->with(['items'])->first();

        // Mail::to($shop->email)->send(new OrderCreated($shop,$customer,$orderdetails));
        // dd($order);

        return redirect()->route('home')->with('status', 'Order Placed Successfully!');
    }
}
