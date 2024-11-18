<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            return view('checkout', compact('product', 'user'));
        }
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'        => 'required|string|max:200',
            'last_name'         => 'nullable|string|max:200',
            'email'             => 'required|email|max:200',
            'mobile'            => 'required|string|max:15',
            'order_type'        => 'required|string|max:50',
            'notes'             => 'nullable|string',
            'payment_type'      => 'required|string|max:50',
            'total'             => 'nullable|numeric|min:0.01',
            'service_date'      => 'nullable|date',
            'service_time'      => 'nullable|string|max:10',
            'quantity'          => 'nullable|integer|min:1',
            'street'            => 'required|string',
            'city'              => 'required|string',
            'state'             => 'required|string',
            'country'           => 'required|string',
            'zipCode'           => 'required|string',
            'coupon_applied'    => 'nullable|boolean',
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
            'total.numeric'          => 'The total amount must be a valid number.',
            'total.min'              => 'The total amount must be greater than 0.',
            'service_date.date'      => 'Please provide a valid service date.',
            'service_time.string'    => 'Service time must be a valid text.',
            'service_time.max'       => 'Service time may not exceed 10 characters.',
            'quantity.integer'       => 'Quantity must be a whole number.',
            'quantity.min'           => 'Quantity must be at least 1.',
            'street.required'        => 'Street is required.',
            'city.required'          => 'City is required.',
            'state.required'         => 'State is required.',
            'country.required'       => 'Country is required.',
            'zipCode.required'       => 'Zip Code is required.',
            'coupon_applied.boolean' => 'Coupon applied must be either true or false.',
            'product_id.required'    => 'Product ID is required.',
            'product_id.integer'     => 'Product ID must be a valid integer.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        $deliveryAddress = "{$validatedData['street']}, {$validatedData['city']}, {$validatedData['state']}, {$validatedData['country']}, {$validatedData['zipCode']}";
        $user_id = Auth::check() ? Auth::id() : null;
        $product = Product::with(['shop'])->where('id', $validatedData['product_id'])->where('active', 1)->first();
        $order = Order::create([
            'customer_id'      => $user_id,
            'shop_id'          => $product->shop_id,
            'first_name'       => $validatedData['first_name'],
            'last_name'        => $validatedData['last_name'],
            'email'            => $validatedData['email'],
            'mobile'           => $validatedData['mobile'],
            'order_type'       => $validatedData['order_type'],
            'notes'            => $validatedData['notes'] ?? null,
            'payment_type'     => $validatedData['payment_type'],
            'payment_status'   => $validatedData['payment_status'] ?? "Pending",
            'service_date'     => $validatedData['service_date'] ?? null,
            'service_time'     => $validatedData['service_time'] ?? null,
            'quantity'         => $validatedData['quantity'] ?? 1,
            'delivery_address' => $deliveryAddress,
            'coupon_applied'   => $validatedData['coupon_applied'] ?? false,
            'total'            => $validatedData['total']
        ]);

        if ($order) {
            OrderItems::create([
                'order_id'         => $order->id,
                'product_id'       => $product->id,
                'item_description' => $product->description ?? null,
                'quantity'         => $validatedData['quantity'] ?? 1,
                'unit_price'       => $product['discounted_price'],
            ]);
        }

        $statusMessage = $validatedData['order_type'] == 'Product'
            ? 'Order Created Successfully!'
            : 'Service Booked Successfully!';

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

        $orders_count = $orders->count();

        return view('orders', compact('orders', 'orders_count'));
    }

    public function showOrderByCustomerId($id)
    {
        $order = Order::with(['items.product', 'shop', 'customer',])->find($id);

        return view('orderView', compact('order'));
    }
}
