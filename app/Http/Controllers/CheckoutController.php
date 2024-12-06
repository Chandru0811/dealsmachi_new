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
            $order = Order::where('customer_id',$user->id)->orderBy('id', 'desc')->first();
            return view('checkout', compact('product', 'user','order'));
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

        $shop = Shop::where('id',$product->shop_id)->first();
        $customer = User::where('id',$user_id)->first();
        $orderdetails = Order::where('id',$order->id)->with(['items'])->first();

        Mail::to($shop->email)->send(new OrderCreated($shop,$customer,$orderdetails));

        return redirect()->route('customer.orderById', ['id' => $order->id])->with('status', $statusMessage);
    }

    public function getAllOrdersByCustomer()
    {
        $customerId = Auth::check() ? Auth::id() : null;
        
        $orders = Order::where('customer_id', $customerId)
            ->with([
                'items.product' => function ($query) {
                    $query->select('id', 'name', 'image_url1', 'description', 'original_price', 'discounted_price', 'discount_percentage');
                },
                'shop' => function ($query) {
                    $query->select('id', 'name');
                },
                'customer' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->orderBy('created_at', 'desc')->get();

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

}
