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
            $product = Product::with(['shop'])->where('id', $id)->where('active', 1)->first();
            return view('checkout', compact('product'));
        }
    }

    public function checkout(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name'        => 'required|string|max:200',
            'last_name'         => 'required|string|max:200',
            'email'             => 'required|email|max:200',
            'mobile'            => 'required|string|max:15',
            'order_type'        => 'required|string|max:50',
            'notes'             => 'nullable|string',
            'payment_type'      => 'required|string|max:50',
            'total'             => 'nullable|numeric|min:0.01',
            'service_date'      => 'nullable|date',
            'service_time'      => 'nullable|string|max:10',
            'quantity'          => 'nullable|integer|min:1',
            'billing_street'   => 'required|string',
            'billing_city'   => 'required|string',
            'billing_state'   => 'required|string',
            'billing_country'   => 'required|string',
            'billing_zipCode'   => 'required|string',
            'sameAsShipping' => 'nullable|integer|in:0,1',
            'shipping_street'   => 'nullable|string',
            'shipping_city'   => 'nullable|string',
            'shipping_state'   => 'nullable|string',
            'shipping_country'   => 'nullable|string',
            'shipping_zipCode'   => 'nullable|string',
            'coupon_applied'    => 'nullable|boolean',
            'product_id'        => 'required|integer'
        ], [
            'first_name.required' => 'Please provide your first name.',
            'first_name.string' => 'First name must be a valid text.',
            'first_name.max' => 'First name may not exceed 200 characters.',

            'last_name.required' => 'Please provide your last name.',
            'last_name.string' => 'Last name must be a valid text.',
            'last_name.max' => 'Last name may not exceed 200 characters.',

            'email.required' => 'Please provide an email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email may not exceed 200 characters.',

            'mobile.required' => 'Please provide a mobile number.',
            'mobile.string' => 'Mobile number must be a valid text.',
            'mobile.max' => 'Mobile number may not exceed 15 characters.',

            'order_type.required' => 'Please specify the order type.',
            'order_type.string' => 'Order type must be a valid text.',
            'order_type.max' => 'Order type may not exceed 50 characters.',

            'payment_type.required' => 'Please specify the payment type.',
            'payment_type.string' => 'Payment type must be a valid text.',
            'payment_type.max' => 'Payment type may not exceed 50 characters.',

            'total.numeric' => 'The total amount must be a valid number.',
            'total.min' => 'The total amount must be greater than 0.',

            'service_date.date' => 'Please provide a valid service date.',

            'service_time.string' => 'Service time must be a valid text.',
            'service_time.max' => 'Service time may not exceed 10 characters.',

            'quantity.integer' => 'Quantity must be a whole number.',
            'quantity.min' => 'Quantity must be at least 1.',

            'billing_address.required' => 'Billing address is required.',
            'billing_address.string' => 'Billing address must be valid text.',
            'billing_address.max' => 'Billing address may not exceed 255 characters.',

            'shipping_address.required' => 'Shipping address is required.',
            'shipping_address.string' => 'Shipping address must be valid text.',
            'shipping_address.max' => 'Shipping address may not exceed 255 characters.',

            'coupon_applied.boolean' => 'Coupon applied must be either true or false.',

            'product_id.required' => 'Product ID is required.',
            'product_id.integer' => 'Product ID must be a valid integer.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Begin database transaction
        $validatedData = $validator->validated();

        $billingAddress = "{$validatedData['billing_street']}, {$validatedData['billing_city']}, {$validatedData['billing_state']}, {$validatedData['billing_country']}, {$validatedData['billing_zipCode']}";
        $sameAsShipping = $validatedData['sameAsShipping'] ?? 0;
        $shippingAddress = ($sameAsShipping  !== "1")
            ? "{$validatedData['shipping_street']}, {$validatedData['shipping_city']}, {$validatedData['shipping_state']}, {$validatedData['shipping_country']}, {$validatedData['shipping_zipCode']}"
            : "{$validatedData['billing_street']}, {$validatedData['billing_city']}, {$validatedData['billing_state']}, {$validatedData['billing_country']}, {$validatedData['billing_zipCode']}";
        $user_id = Auth::check() ? Auth::id() : null;
        $product = Product::with(['shop'])->where('id', $validatedData['product_id'])->where('active', 1)->first();
        $order = Order::create([
            'customer_id' => $user_id,
            'shop_id' => $product->shop_id,
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'mobile' => $validatedData['mobile'],
            'order_type' => $validatedData['order_type'],
            'notes' => $validatedData['notes'] ?? null,
            'payment_type' => $validatedData['payment_type'],
            'payment_status' => $validatedData['payment_status'] ?? "Pending",
            'service_date' => $validatedData['service_date'] ?? null,
            'service_time' => $validatedData['service_time'] ?? null,
            'quantity' => $validatedData['quantity'] ?? null,
            'billing_address' => $billingAddress,
            'shipping_address' => $shippingAddress,
            'coupon_applied' => $validatedData['coupon_applied'] ?? false,
            'total' => $validatedData['total']
        ]);

        if ($order) {
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'item_description' => $product->description ?? null,
                'quantity' => $validatedData['quantity'],
                'unit_price' => $product['discounted_price'],
            ]);
        }

        return redirect()->route('home')->with('status', 'Order Created Successfully!');
    }
}
