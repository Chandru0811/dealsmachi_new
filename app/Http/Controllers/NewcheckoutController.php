<?php
namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewcheckoutController extends Controller
{
    public function proceedonlinepayment(Request $request)
    {
        $cart_id        = $request->input('cart_id');
        $amount         = $request->input('amount');
        $cartDetail     = Cart::where('id', $cart_id)->first();
        $addressId      = $request->input('address_id');
        $address        = Address::find($addressId);
        $requiredfields = [
            $address->first_name,
            $address->address,
            $address->state,
            $address->city,
            $address->postalcode,
        ];

        $deliveryaddress = implode(',', $requiredfields);

        if (! $address) {
            return redirect()->route('home')->with('error', 'Address not found.');
        }

        //create order number
        $latestOrder   = Order::orderBy('id', 'desc')->first();
        $customOrderId = $latestOrder ? intval(Str::after($latestOrder->id, '-')) + 1 : 1;
        $orderNumber   = 'DEALSMACHI_O' . now()->format('His') . $customOrderId;

        $date      = Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i:sP');
        $userAgent = $request->header('User-Agent');
        if ($userAgent === 'Symfony') {
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        }

        $requestPayload = [
            "mercid"          => env('UAT_BILLDESK_MERCHANT_ID'),
            "orderid"         => $orderNumber,
            "amount"          => $amount,
            "order_date"      => $date,
            "currency"        => "356",
            "ru"              => env('UAT_BILLDESK_RETURN_URL'),
            "additional_info" => [
                "additional_info1" => $deliveryaddress,
                "additional_info2" => $cartDetail->id,
                "additional_info3" => $addressId,
                "additional_info4" => "NA",
                "additional_info5" => "NA",
                "additional_info6" => "NA",
                "additional_info7" => "NA",
            ],
            "itemcode"        => "DIRECT",
            "device"          => [
                "init_channel"               => "internet",
                "ip"                         => $request->ip(),
                "user_agent"                 => $userAgent,
                "accept_header"              => $request->header('Accept'),
                "browser_tz"                 => $request->input('browser_tz', '-330'), // Default: -330 (IST Offset)
                "browser_color_depth"        => $request->input('browser_color_depth', '32'),
                "browser_java_enabled"       => $request->input('browser_java_enabled', 'false'),
                "browser_screen_height"      => $request->input('browser_screen_height', '601'),
                "browser_screen_width"       => $request->input('browser_screen_width', '657'),
                "browser_language"           => $request->header('Accept-Language', 'en-US'),
                "browser_javascript_enabled" => $request->input('browser_javascript_enabled', 'true'),
            ],
        ];

        $datas = [
            'ordernumber'    => $orderNumber,
            'amount'         => $cartDetail->grand_total,
            'address'        => $deliveryaddress,
            'requestPayload' => $requestPayload,
        ];

        $transaction = $this->makepayment($datas);

        $cartDetail->request_token  = $transaction['request_token'] ?? null;
        $cartDetail->response_token = $transaction['response_token'] ?? null;
        $cartDetail->bdorderid      = $transaction['bdorderid'] ?? null;
        $cartDetail->mercid         = $transaction['mercid'] ?? null;
        $cartDetail->order_date     = $transaction['order_date'] ?? null;
        $cartDetail->save();

        $cart        = Cart::where('id', $cart_id)->with('items')->first();
        $user        = Auth::user();
        $orderoption = 'cart';
        $href        = $transaction['href'];
        $bdorderid   = $transaction['bdorderid'];
        $mercid      = $transaction['mercid'];
        $rdata       = $transaction['rdata'];

        // return view('checkout', compact('cart', 'user', 'address', 'orderoption', 'bdorderid', 'mercid', 'rdata', 'href'));
        return response()->json([
            'cart'        => $cart,
            'user'        => $user,
            'address'     => $address,
            'orderoption' => $orderoption,
            'bdorderid'   => $bdorderid,
            'mercid'      => $mercid,
            'rdata'       => $rdata,
            'href'        => $href,
        ]);
    }

    public function makepayment(array $requestData)
    {
        $orderId        = $requestData['id'] ?? null;
        $orderNumber    = $requestData['ordernumber'] ?? null;
        $amount         = $requestData['amount'] ?? null;
        $address        = $requestData['address'] ?? null;
        $requestPayload = $requestData['requestPayload'] ?? null;
        $merchantKey    = env('UAT_BILLDESK_SECRET_KEY');
        // Generate HMAC Signature
        $signature = $this->generateHmacSignature($requestPayload, $merchantKey);

        // Add to Authorization Header
        $headers = [
            "Content-Type" => "application/jose",
            "Accept"       => "application/jose",
            "BD-Timestamp" => time(),
            "BD-Traceid"   => uniqid(),
        ];

        $billDeskUrl = env('UAT_BILLDESK_ORDER_URL');

        $response = Http::withHeaders($headers)->withBody($signature, 'application/jose')->post($billDeskUrl);

        if ($response->successful()) {
            $responseData   = $response->body();
            $tokenParts     = explode('.', $responseData);
            $header         = json_decode(base64_decode($tokenParts[0]), true);
            $payload        = json_decode(base64_decode($tokenParts[1]), true);
            $bdorderid      = $payload['bdorderid'] ?? null;
            $mercid         = $payload['mercid'] ?? null;
            $order_date     = $payload['order_date'] ?? null;
            $request_token  = $signature;
            $response_token = $responseData;
            $links          = $payload['links'];
            $rdata          = $links[1]['parameters']['rdata'] ?? null;
            $href           = $links[1]['href'] ?? null;
            $returndatas    = [
                "rdata"          => $rdata,
                "href"           => $href,
                "mercid"         => $mercid,
                "bdorderid"      => $bdorderid,
                "request_token"  => $request_token,
                "response_token" => $response_token,
                "order_date"     => $order_date,
            ];
            return $returndatas;

        } else {
            Log::error("BillDesk API Error: " . $response->body());
            return [
                "status"   => "error",
                "message"  => "BillDesk Order API failed",
                "response" => $response->json(),
            ];
        }
    }

    public function generateHmacSignature($requestPayload, $merchantKey)
    {
        try {
            $jwsHeader = [
                "alg"      => "HS256",
                "clientid" => env('UAT_BILLDESK_CLIENT_ID'),
            ];

            $base64UrlHeader  = rtrim(strtr(base64_encode(json_encode($jwsHeader)), '+/', '-_'), '=');
            $base64UrlPayload = rtrim(strtr(base64_encode(json_encode($requestPayload)), '+/', '-_'), '=');

            $signature          = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", $merchantKey, true);
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
        if ($request->status == 409) {
            $message         = $request->message;
            $currentDateTime = now();
            Log::error('Payment Failed', [
                'message'   => $message,
                'date_time' => $currentDateTime,
            ]);

            return view('orders.error');
        } elseif ($request->status == 500 || $request->status == 502 || $request->status == 504) {
            return view('orders.failed');
        }

        $transactionResponse = $request->input('transaction_response');
        //dd($transactionResponse);
        $transactiondetails     = explode('.', $transactionResponse);
        $header                 = json_decode(base64_decode($transactiondetails[0]), true);
        $payload                = json_decode(base64_decode($transactiondetails[1]), true);
        $transaction_error_code = $payload['transaction_error_code'] ?? null;
        $payment_method_type    = $payload['payment_method_type'] ?? null;
        $transactionid          = $payload['transactionid'] ?? null;
        $charge_amount          = $payload['charge_amount'] ?? null;
        $transaction_error_type = $payload['transaction_error_type'] ?? null;
        $orderid                = $payload['orderid'] ?? null;
        $additional_info        = $payload['additional_info'];
        $delivery_address       = $additional_info['additional_info1'] ?? null;
        $cart_id                = $additional_info['additional_info2'] ?? null;
        $address_id             = $additional_info['additional_info3'] ?? null;
        $user_id                = Auth::check() ? Auth::id() : null;
        $address                = Address::find($address_id);
        $deliveryAddress        = [
            'first_name' => $address->first_name,
            'last_name'  => $address->last_name,
            'email'      => $address->email,
            'phone'      => $address->phone,
            'postalcode' => $address->postalcode,
            'address'    => $address->address,
            'city'       => $address->city,
            'state'      => $address->state,
            'unit'       => $address->unit,
        ];
        if ($transaction_error_code == "TRS0000") {
            if ($cart_id) {
                $cart = Cart::with('items')->where('id', $cart_id)->first();

                $order = Order::create([
                    'order_number'        => $orderid,
                    'customer_id'         => $user_id,
                    'item_count'          => $cart->item_count,
                    'quantity'            => $cart->quantity,
                    'total'               => $cart->total,
                    'discount'            => $cart->discount,
                    'shipping'            => $cart->shipping,
                    'packaging'           => $cart->packaging,
                    'handling'            => $cart->handling,
                    'taxes'               => $cart->taxes,
                    'grand_total'         => $cart->grand_total,
                    'shipping_weight'     => $cart->shipping_weight,
                    'status'              => 2, //created
                    'payment_type'        => 'online_payment',
                    'payment_status'      => 3, //paid
                    'delivery_address'    => json_encode($deliveryAddress),
                    'address_id'          => $address_id,
                    'request_token'       => $cart->request_token,
                    'response_token'      => $cart->response_token,
                    'bdorderid'           => $cart->bdorderid,
                    'mercid'              => $cart->mercid,
                    "order_date"          => $cart->order_date,
                    'payment_method_type' => $payload['payment_method_type'] ?? null,
                    'transactionid'       => $payload['transactionid'] ?? null,
                    'charge_amount'       => $payload['charge_amount'] ?? null,
                    'transaction_token'   => $transactionResponse,
                    'transaction_status'  => $transaction_error_type,
                ]);

                foreach ($cart->items as $item) {
                    $itemNumber = 'DM0' . $order->id . '-V' . $item->product->shop_id . 'P' . $item->product_id;

                    OrderItems::create([
                        'order_id'         => $order->id,
                        'item_number'      => $itemNumber,
                        'product_id'       => $item->product_id,
                        'seller_id'        => $item->product->shop_id,
                        'item_description' => $item->item_description,
                        'quantity'         => $item->quantity,
                        'unit_price'       => $item->unit_price,
                        'delivery_date'    => $item->delivery_date,
                        'coupon_code'      => $item->coupon_code,
                        'discount'         => $item->discount,
                        'discount_percent' => $item->discount_percent,
                        'deal_type'        => $item->deal_type,
                        'service_date'     => $item->service_date,
                        'service_time'     => $item->service_time,
                        'shipping'         => $item->shipping ?? 0,
                        'packaging'        => $item->packaging ?? 0,
                        'handling'         => $item->handling ?? 0,
                        'taxes'            => $item->taxes ?? 0,
                        'shipping_weight'  => $item->shipping_weight ?? 0,
                    ]);
                }

                $product = Product::find($item->product_id);
                if ($product) {
                    $product->stock -= $item->quantity;
                    $product->save();
                }

                $cart->items()->delete();
                $cart->delete();

                return view('orders.success', ['address' => $delivery_address]);
            }
        } elseif ($transaction_error_code == "TRPPE0033") {
            return view('orders.error');
        }
    }

    public function confirmcod(Request $request)
    {
        $user_id = Auth::check() ? Auth::id() : null;
        $cart_id = $request->input('cart_id');
        $cart    = Cart::with('items')->where('id', $cart_id)->first();
        if (! $cart) {
            return redirect()->route('home')->with('error', 'Cart not found.');
        }

        // Create order for the cart items
        $latestOrder   = Order::orderBy('id', 'desc')->first();
        $customOrderId = $latestOrder ? intval(Str::after($latestOrder->id, '-')) + 1 : 1;
        $orderNumber   = 'DEALSMACHI_O' . now()->format('His') . $customOrderId;
        $addressId     = $request->input('address_id');
        $address       = Address::find($addressId);

        if (! $address) {
            return redirect()->route('home')->with('error', 'Address not found.');
        }

        $deliveryAddress = [
            'first_name' => $address->first_name,
            'last_name'  => $address->last_name,
            'email'      => $address->email,
            'phone'      => $address->phone,
            'postalcode' => $address->postalcode,
            'address'    => $address->address,
            'city'       => $address->city,
            'state'      => $address->state,
            'unit'       => $address->unit,
        ];

        $order = Order::create([
            'order_number'     => $orderNumber,
            'customer_id'      => $user_id,
            'item_count'       => $cart->item_count,
            'quantity'         => $cart->quantity,
            'total'            => $cart->total,
            'discount'         => $cart->discount,
            'shipping'         => $cart->shipping,
            'packaging'        => $cart->packaging,
            'handling'         => $cart->handling,
            'taxes'            => $cart->taxes,
            'grand_total'      => $cart->grand_total,
            'shipping_weight'  => $cart->shipping_weight,
            'status'           => 1, //created
            'payment_type'     => 'cash_on_delivery',
            'payment_status'   => 1,
            'delivery_address' => json_encode($deliveryAddress),
        ]);

        foreach ($cart->items as $item) {
            $itemNumber = 'DM0' . $order->id . '-V' . $item->product->shop_id . 'P' . $item->product_id;

            OrderItems::create([
                'order_id'         => $order->id,
                'item_number'      => $itemNumber,
                'product_id'       => $item->product_id,
                'seller_id'        => $item->product->shop_id,
                'item_description' => $item->item_description,
                'quantity'         => $item->quantity,
                'unit_price'       => $item->unit_price,
                'delivery_date'    => $item->delivery_date,
                'coupon_code'      => $item->coupon_code,
                'discount'         => $item->discount,
                'discount_percent' => $item->discount_percent,
                'deal_type'        => $item->deal_type,
                'service_date'     => $item->service_date,
                'service_time'     => $item->service_time,
                'shipping'         => $item->shipping ?? 0,
                'packaging'        => $item->packaging ?? 0,
                'handling'         => $item->handling ?? 0,
                'taxes'            => $item->taxes ?? 0,
                'shipping_weight'  => $item->shipping_weight ?? 0,
            ]);
        }
        // Delete cart and cart items
        $cart->items()->delete();
        $cart->delete();

        $decodedAddress = json_decode($order->delivery_address, true);

        $addressFields = [
            'address'     => $decodedAddress['address'] ?? '',
            'city'        => $decodedAddress['city'] ?? '',
            'state'       => $decodedAddress['state'] ?? '',
            'postal_code' => $decodedAddress['postal_code'] ?? '',
            'unit'        => $decodedAddress['unit'] ?? '',
        ];

        $product = Product::find($item->product_id);
        if ($product) {
            $product->stock -= $item->quantity;
            $product->save();
        }

        // dd($product->stock);

        $formattedAddress = implode(", ", array_filter([
            $addressFields['address'],
            $addressFields['city'],
            $addressFields['state'],
            $addressFields['postal_code'],
        ]));

        if ($addressFields['unit']) {
            $formattedAddress .= " - " . $addressFields['unit'];
        }
        return view('orders.success', ['address' => $formattedAddress]);
    }
}
