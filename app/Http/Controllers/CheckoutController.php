<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
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
use DB;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    private function cleanUpCart($cart)
    {
        CartHelper::cleanUpCart($cart);
    }

    public function checkoutsummary($id, Request $request)
    {
        if (!Auth::check()) {
            session(['url.intended' => route('checkout.summary')]);

            return redirect()->route("login");
        } else {
            $user = Auth::user();

            $products = Product::with(['productMedia:id,resize_path,order,type,imageable_id', 'shop'])->where('id', $id)->where('active', 1)->get();

            if (!$products) {
                return redirect()->route('home')->with('error', 'Product not found or inactive.');
            }

            $carts = Cart::whereNull('customer_id')->where('ip_address', $request->ip());

            if (Auth::guard()->check()) {
                $carts = $carts->orWhere('customer_id', Auth::guard()->user()->id);
            }

            $carts = $carts->first();

            if ($carts) {
                $this->cleanUpCart($carts);
                $matchedItem = $carts->items()->where('product_id', $id)->first();
                if ($matchedItem) {
                    $products->each(function ($product) use ($matchedItem) {
                        $product->quantity = $matchedItem->quantity;
                    });
                }

                $carts->load([
                    'items' => function ($query) use ($id) {
                        $query->where('product_id', '!=', $id);
                    },
                    'items.product.productMedia:id,resize_path,order,type,imageable_id',
                    'items.product.shop'
                ]);

                if (!empty($carts->items) && $carts->items->isNotEmpty()) {
                    $carts->items = $carts->items->filter(function ($item) {
                        return !(
                            !empty($item->product) &&
                            !empty($item->product->shop) &&
                            $item->product->shop->is_direct == 1 &&
                            isset($item->product->stock) &&
                            $item->product->stock == 0
                        );
                    });
                }

            } else {
                $products->each(function ($product) {
                    $product->quantity = 1;
                });
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

    public function directcheckout(Request $request)
    {
        // dd($request->all());
        $product_ids = $request->input('all_products_to_buy');
        $ids = json_decode($product_ids);
        $address_id = $request->input('address_id');
        $cart_id = $request->input('cart_id');
        $address = Address::where('id', $address_id)->first();
        $orderoption = "buy now";
        $cart = Cart::where('id', $cart_id)->with('items')->first();
        if ($cart) {
            $cart->load([
                'items' => function ($query) use ($ids) {
                    $query->whereIn('product_id', $ids);
                }
            ]);
        }

        if (!Auth::check()) {
            session(['url.intended' => route('checkout.direct')]);
            return redirect()->route("login");
        } else {
            $user = Auth::user();
            $order = Order::where('customer_id', $user->id)->orderBy('id', 'desc')->first();
            $orderoption = 'buynow';
            return view('checkout', compact('cart', 'user', 'address', 'order', 'orderoption', 'product_ids'));
        }
    }

    public function cartcheckout(Request $request)
    {
        $address_id = $request->address_id;
        $cart_id = $request->input('cart_id');
        $address = Address::where('id', $address_id)->first();
        $cart = Cart::where('id', $cart_id)->with('items')->first();
        if (!$cart) {
            return redirect()->route('home')->with('error', 'Cart not found.');
        }

        if (!Auth::check()) {
            session(['url.intended' => route('checkout.cart', ['cart_id' => $cart_id])]);
            return redirect()->route("login");
        } else {
            $user = Auth::user();
            $orderoption = 'cart';
            return view('checkout', compact('cart', 'user', 'address', 'orderoption'));
        }
    }

    public function createorder(Request $request)
    {
        // dd($request->all());
        $user_id = Auth::check() ? Auth::id() : null;
        $cart_id = $request->input('cart_id');
        $product_ids = $request->input('product_ids');
        $payment_type = $request->input('payment_type');

        if ($product_ids != null && $cart_id != null) {
            $ids = json_decode($product_ids);
            $cart = Cart::where('id', $cart_id)->with('items')->first();

            if (!$cart) {
                return redirect()->route('home')->with('error', 'Cart not found.');
            }

            $cart->load([
                'items' => function ($query) use ($ids) {
                    $query->whereIn('product_id', $ids);
                }
            ]);

            // Generate a custom order number
            $latestOrder = Order::orderBy('id', 'desc')->first();
            $customOrderId = $latestOrder ? intval(Str::after($latestOrder->id, '-')) + 1 : 1;
            $orderNumber = 'DEALSMACHI_O' . $customOrderId;

            $itemCount = $cart->items->whereIn('product_id', $ids)->sum('quantity');

            $total = $cart->items->whereIn('product_id', $ids)->sum(function ($item) {
                return $item->unit_price * $item->quantity;
            });
            $discount = $cart->items->whereIn('product_id', $ids)->sum(function ($item) {
                return ($item->unit_price - $item->discount) * $item->quantity;
            });
            $shipping = $cart->items->whereIn('product_id', $ids)->sum('shipping');
            $packaging = $cart->items->whereIn('product_id', $ids)->sum('packaging');
            $handling = $cart->items->whereIn('product_id', $ids)->sum('handling');
            $taxes = $cart->items->whereIn('product_id', $ids)->sum('taxes');
            $grandTotal = $total - $discount + $shipping + $packaging + $handling + $taxes;
            $shippingWeight = $cart->items->whereIn('product_id', $ids)->sum('shipping_weight');

            $addressId = $request->input('address_id');
            $address = Address::find($addressId);

            if (!$address) {
                return redirect()->route('home')->with('error', 'Address not found.');
            }

            $deliveryAddress = [
                'first_name' => $address->first_name,
                'last_name' => $address->last_name,
                'email' => $address->email,
                'phone' => $address->phone,
                'postalcode' => $address->postalcode,
                'address' => $address->address,
                'city' => $address->city,
                'state' => $address->state,
                'unit' => $address->unit
            ];

            // Create the order
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $user_id,
                'item_count' => $itemCount,
                'quantity' => $itemCount,
                'total' => $total,
                'discount' => $discount,
                'shipping' => $shipping,
                'packaging' => $packaging,
                'handling' => $handling,
                'taxes' => $taxes,
                'grand_total' => $grandTotal,
                'shipping_weight' => $shippingWeight,
                'status' => 1, // Created
                'payment_type' => $request->input('payment_type'),
                'payment_status' => 1,
                'delivery_address' => json_encode($deliveryAddress)
            ]);

            // Create order items
            foreach ($cart->items->whereIn('product_id', $ids) as $item) {
                $itemNumber = 'DM0' . $order->id . '-V' . $item->product->shop_id . 'P' . $item->product_id;

                OrderItems::create([
                    'order_id' => $order->id,
                    'item_number' => $itemNumber,
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

            // Delete ordered items from the cart
            foreach ($cart->items->whereIn('product_id', $ids) as $cart_item) {
                $cart->item_count -= 1; // Decrease item count
                $cart->quantity -= $cart_item->quantity; // Decrease total quantity
                $cart->total -= ($cart_item->unit_price * $cart_item->quantity); // Subtract total price
                $cart->discount -= (($cart_item->unit_price - $cart_item->discount) * $cart_item->quantity); // Subtract discount
                $cart->shipping -= $cart_item->shipping; // Subtract shipping cost
                $cart->packaging -= $cart_item->packaging; // Subtract packaging cost
                $cart->handling -= $cart_item->handling; // Subtract handling cost
                $cart->taxes -= $cart_item->taxes; // Subtract taxes
                $cart->grand_total -= (
                    ($cart_item->discount * $cart_item->quantity) +
                    $cart_item->shipping +
                    $cart_item->packaging +
                    $cart_item->handling +
                    $cart_item->taxes
                ); // Update grand total
                $cart->shipping_weight -= $cart_item->shipping_weight; // Subtract shipping weight

                $cart_item->delete(); // Delete the cart item
            }

            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }

            // Save updated cart or delete if empty
            if ($cart->item_count <= 0 || $cart->quantity <= 0) {
                $cart->delete();
            } else {
                $cart->save(); // Save updated cart
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
            $orderNumber = 'DEALSMACHI_O' . now()->format('His') . $customOrderId;
            $addressId = $request->input('address_id');
            $address = Address::find($addressId);

            if (!$address) {
                return redirect()->route('home')->with('error', 'Address not found.');
            }

            $deliveryAddress = [
                'first_name' => $address->first_name,
                'last_name' => $address->last_name,
                'email' => $address->email,
                'phone' => $address->phone,
                'postalcode' => $address->postalcode,
                'address' => $address->address,
                'city' => $address->city,
                'state' => $address->state,
                'unit' => $address->unit
            ];

            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $user_id,
                'item_count' => $cart->item_count,
                'quantity' => $cart->quantity,
                'total' => $cart->total,
                'discount' => $cart->discount,
                'shipping' => $cart->shipping,
                'packaging' => $cart->packaging,
                'handling' => $cart->handling,
                'taxes' => $cart->taxes,
                'grand_total' => $cart->grand_total,
                'shipping_weight' => $cart->shipping_weight,
                'status' => 1, //created
                'payment_type' => $request->input('payment_type'),
                'payment_status' => 1,
                'delivery_address' => json_encode($deliveryAddress)
            ]);

            foreach ($cart->items as $item) {
                $itemNumber = 'DM0' . $order->id . '-V' . $item->product->shop_id . 'P' . $item->product_id;

                OrderItems::create([
                    'order_id' => $order->id,
                    'item_number' => $itemNumber,
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

            $decodedAddress = json_decode($order->delivery_address, true);

            $addressFields = [
                'address' => $decodedAddress['address'] ?? '',
                'city' => $decodedAddress['city'] ?? '',
                'state' => $decodedAddress['state'] ?? '',
                'postal_code' => $decodedAddress['postal_code'] ?? '',
                'unit' => $decodedAddress['unit'] ?? ''
            ];

            $formattedAddress = implode(", ", array_filter([
                $addressFields['address'],
                $addressFields['city'],
                $addressFields['state'],
                $addressFields['postal_code'],
            ]));

            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock -= $item->quantity;
                $product->save();
            }

            if ($addressFields['unit']) {
                $formattedAddress .= " - " . $addressFields['unit'];
            }

            if ($payment_type == "online_payment") {
                $date = Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i:sP');
                $userAgent = $request->header('User-Agent');
                if ($userAgent === 'Symfony') {
                    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
                }


                $requestPayload = [
                    "mercid" => env('UAT_BILLDESK_MERCHANT_ID'),
                    "orderid" => $orderNumber,
                    "amount" => $order->grand_total,
                    "order_date" => $date,
                    "currency" => "356",
                    "ru" => env('UAT_BILLDESK_RETURN_URL'),
                    "additional_info" => [
                        "additional_info1" => $formattedAddress,
                        "additional_info2" => "NA",
                        "additional_info3" => "NA",
                        "additional_info4" => "NA",
                        "additional_info5" => "NA",
                        "additional_info6" => "NA",
                        "additional_info7" => "NA"
                    ],
                    "itemcode" => "DIRECT",
                    "device" => [
                        "init_channel" => "internet",
                        "ip" => $request->ip(),
                        "user_agent" => $userAgent,
                        "accept_header" => $request->header('Accept'),
                        "browser_tz" => $request->input('browser_tz', '-330'), // Default: -330 (IST Offset)
                        "browser_color_depth" => $request->input('browser_color_depth', '32'),
                        "browser_java_enabled" => $request->input('browser_java_enabled', 'false'),
                        "browser_screen_height" => $request->input('browser_screen_height', '601'),
                        "browser_screen_width" => $request->input('browser_screen_width', '657'),
                        "browser_language" => $request->header('Accept-Language', 'en-US'),
                        "browser_javascript_enabled" => $request->input('browser_javascript_enabled', 'true'),
                    ]
                ];

                $datas = [
                    'id' => $order->id,
                    'ordernumber' => $orderNumber,
                    'amount' => $order->grand_total,
                    'address' => $formattedAddress,
                    'requestPayload' => $requestPayload
                ];

                $transaction = $this->startpayment($datas);
                return view('paymentscreen', $transaction);
            } else {
                return view('orders.success', ['address' => $formattedAddress]);
            }
        } else {
            return redirect()->route('home')->with('error', 'Invalid request.');
        }

        // $shop = Shop::where('id',$product->shop_id)->first();
        //$customer = User::where('id', $user_id)->first();
        //$orderdetails = Order::where('id', $order->id)->with(['items'])->first();

        // Mail::to($shop->email)->send(new OrderCreated($shop,$customer,$orderdetails));
        // dd($order);

        // $decodedAddress = json_decode($order->delivery_address, true);

        // $addressFields = [
        //     'address' => $decodedAddress['address'] ?? '',
        //     'city' => $decodedAddress['city'] ?? '',
        //     'state' => $decodedAddress['state'] ?? '',
        //     'postal_code' => $decodedAddress['postal_code'] ?? '',
        //     'unit' => $decodedAddress['unit'] ?? ''
        // ];

        // $formattedAddress = implode(", ", array_filter([
        //     $addressFields['address'],
        //     $addressFields['city'],
        //     $addressFields['state'],
        //     $addressFields['postal_code'],
        // ]));

        // if ($addressFields['unit']) {
        //     $formattedAddress .= " - " . $addressFields['unit'];
        // }

        // $message = [
        //     'order' => "Order Placed Successfully !",
        //     'delivery' => "Delivering to",
        //     'address' => $formattedAddress
        // ];

        // return redirect()->route('home')->with('status1', $message);

    }

    public function startpayment(array $requestData)
    {
        $orderId = $requestData['id'] ?? null;
        $orderNumber = $requestData['ordernumber'] ?? null;
        $amount = $requestData['amount'] ?? null;
        $address = $requestData['address'] ?? null;
        $requestPayload = $requestData['requestPayload'] ?? null;
        $merchantKey = env('UAT_BILLDESK_SECRET_KEY');
        // Generate HMAC Signature
        $signature = $this->generateHmacSignature($requestPayload, $merchantKey);

        // Add to Authorization Header
        $headers = [
            "Content-Type" => "application/jose",
            "Accept" => "application/jose",
            "BD-Timestamp" => time(),
            "BD-Traceid" => uniqid()
        ];


        $billDeskUrl = env('UAT_BILLDESK_ORDER_URL');

        $response = Http::withHeaders($headers)->withBody($signature, 'application/jose')->post($billDeskUrl);

        if ($response->successful()) {
            $responseData = $response->body();
            $tokenParts = explode('.', $responseData);
            $header = json_decode(base64_decode($tokenParts[0]), true);
            $payload = json_decode(base64_decode($tokenParts[1]), true);
            $bdorderid = $payload['bdorderid'] ?? null;
            $mercid = $payload['mercid'] ?? null;
            $order_date = $payload['order_date'] ?? null;
            $request_token = $signature;
            $response_token = $responseData;
            $links = $payload['links'];
            $rdata = $links[1]['parameters']['rdata'] ?? null;
            $href = $links[1]['href'] ?? null;
            $order = Order::find($orderId);
            if ($order) {
                $order->bdorderid      = $payload['bdorderid'] ?? null;
                $order->mercid         = $payload['mercid'] ?? null;
                $order->order_date     = $payload['order_date'] ?? null;
                $order->request_token  = $signature;
                $order->response_token = $responseData;
                $order->save();

                $returndatas = [
                    "rdata" => $rdata,
                    "href" => $href,
                    "mercid" => $mercid,
                    "bdorderid" => $bdorderid,
                ];
                return $returndatas;
            } else {
                Log::error("Order with ID $order_id not found.");
            }
        } else {
            Log::error("BillDesk API Error: " . $response->body());
            return [
                "status" => "error",
                "message" => "BillDesk Order API failed",
                "response" => $response->json()
            ];
        }
    }

    function generateHmacSignature($requestPayload, $merchantKey)
    {
        try {
            $jwsHeader = [
                "alg" => "HS256",
                "clientid" => env('UAT_BILLDESK_CLIENT_ID')
            ];

            $base64UrlHeader = rtrim(strtr(base64_encode(json_encode($jwsHeader)), '+/', '-_'), '=');
            $base64UrlPayload = rtrim(strtr(base64_encode(json_encode($requestPayload)), '+/', '-_'), '=');

            $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $merchantKey, true);
            $base64UrlSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

            $jwsToken = "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";

            return $jwsToken;
        } catch (\Exception $e) {
            Log::error("HMAC Generation Error: " . $e->getMessage());
            return null;
        }
    }

    public function handleRedirect(Request $request)
    {
        // Get transaction response (for GET or POST requests)
        if ($request->status == 409) {
            $message = $request->message;
            $currentDateTime = now();
            Log::error('Payment Failed', [
                'message' => $message,
                'date_time' => $currentDateTime,
            ]);

            return view('orders.error');
        }

        $transactionResponse = $request->input('transaction_response');
        $transactiondetails = explode('.', $transactionResponse);
        $header = json_decode(base64_decode($transactiondetails[0]), true);
        $payload = json_decode(base64_decode($transactiondetails[1]), true);
        $payment_method_type = $payload['payment_method_type'] ?? null;
        $transactionid = $payload['transactionid'] ?? null;
        $charge_amount = $payload['charge_amount'] ?? null;
        $transaction_error_type = $payload['transaction_error_type'] ?? null;
        $orderid = $payload['orderid'] ?? null;
        $additional_info = $payload['additional_info'];
        $delivery_address = $additional_info['additional_info1'] ?? null;
        $order_id = Order::where('order_number', $orderid)->first();
        $order = Order::find($order_id->id);
        if ($order) {
            $order->payment_method_type      = $payload['payment_method_type'] ?? null;
            $order->transactionid = $payload['transactionid'] ?? null;
            $order->charge_amount     = $payload['charge_amount'] ?? null;
            $order->transaction_token  = $transactionResponse;
            $order->transaction_status  = $transaction_error_type;
            $order->save();
        }

        return view('orders.success', ['address' => $delivery_address]);
    }

    public function getAllOrdersByCustomer()
    {
        $customerId = Auth::check() ? Auth::id() : null;

        $orders = Order::where('customer_id', $customerId)
            ->with([
                'items.product' => function ($query) {
                    $query->select('id', 'name', 'description', 'original_price', 'discounted_price', 'discount_percentage', 'delivery_days')->with('productMedia:id,resize_path,order,type,imageable_id');
                },
                'items.shop' => function ($query) {
                    $query->select('id', 'name')->withTrashed();
                }
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders', compact('orders'));
    }

    public function showOrderByCustomerId($id, $product_id)
    {
        $order = Order::with([
            'items' => function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            },
            'items.product.productMedia:id,resize_path,order,type,imageable_id',
            'items.product.review',
            'items.shop' => function ($query) {
                $query->select('id', 'name', 'email', 'mobile', 'description', 'street', 'street2', 'city', 'zip_code', 'legal_name', 'deleted_at')->withTrashed();
            }
        ])->find($id);

        if (!$order || Auth::id() !== $order->customer_id) {
            return view('orderView', ['order' => null]);
        }

        $orderReviewedByUser = false;

        if ($order->items->count() > 0) {
            foreach ($order->items as $item) {
                // Check if product exists
                if ($item->product && $item->product->review) {
                    $review = $item->product->review->firstWhere('user_id', Auth::id());

                    if ($review) {
                        $orderReviewedByUser = true;
                        break;
                    }
                }
            }
        }
        // dd($order);

        return view('orderView', compact('order', 'orderReviewedByUser'));
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
            $logoBase64 = 'https://dealslah.com/assets/images/home/header-logo.webp';
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
