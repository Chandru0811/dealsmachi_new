<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Order;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        $amount = $request->input('amount');
        $order_id = 'testdata_' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $address = $request->input('address');
        
        $date = Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i:sP');
        $clientId = "bduat2k475";
        $merchantKey = "deliqOW9hvX8bK9tsRGe8UkoU4HwZjjN";
        $userAgent = $request->header('User-Agent');
        if ($userAgent === 'Symfony') {
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
        }
        $requestPayload = [
            "mercid" => "BDUAT2K475",
            "orderid" => $order_id,
            "amount" => $amount,
            "order_date" => $date,
            "currency" => "356",
            "ru" => "https://dealsmachi.com/api/billdesh/transaction/response",
            "itemcode" =>"DIRECT",
            "device" => [
                "init_channel" => "internet",
                "ip" => $request->ip(),
                "user_agent" => $userAgent,
                "accept_header" => $request->header('Accept')
            ]
        ];

        // Generate HMAC Signature
        $signature = $this->generateHmacSignature($requestPayload, $merchantKey);
        
        
        
        // Add to Authorization Header
        $headers = [
            "Content-Type" => "application/jose",
            "Accept" => "application/jose",
            "BD-Timestamp" => time(),
            "BD-Traceid" => uniqid()
        ];
        
        $billDeskUrl = "https://uat1.billdesk.com/u2/payments/ve1_2/orders/create";

        $response = Http::withHeaders($headers)->withBody($signature, 'application/jose')->post($billDeskUrl);
           
        if ($response->successful()) {
            $responseData = $response->body();
            $tokenParts = explode('.', $responseData);
            $header = json_decode(base64_decode($tokenParts[0]), true); 
            $payload = json_decode(base64_decode($tokenParts[1]), true);
            
            return $payload;
            
        } else {
            Log::error("BillDesk API Error: " . $response->body());
            return [
                "status" => "error",
                "message" => "BillDesk Order API failed",
                "response" => $response->json()
            ];
        }
         
    }
    
    public function transresponse(Request $request)
    {
        if($request->status == 409)
        {
            $message = $request->message;
            return $message;
            
        }elseif($request->status == 500 || $request->status == 502 || $request->status == 504)
        {
            return "Bank Server Error";
        }
        
        
        $transactionResponse = $request->input('transaction_response');
        //dd($transactionResponse);
        $transactiondetails = explode('.', $transactionResponse);
        $header = json_decode(base64_decode($transactiondetails[0]), true); 
        $payload = json_decode(base64_decode($transactiondetails[1]), true);
        return $payload;
    }

    function generateHmacSignature($requestPayload, $merchantKey)
    {
       try {
            $jwsHeader = [
                "alg" => "HS256",
                "clientid" => "bduat2k475"
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
    
    function authtest(Request $request)
    {
        $url = 'https://uat1.billdesk.com/u2/payments/ve1_2/orders/create';
    
        $headers = [
            "Content-Type" => "application/jose",
            "Accept" => "application/jose",
            "BD-Timestamp" => time(),
            "BD-Traceid" => uniqid()
        ];
    
        $body = 'eyJhbGciOiJIUzI1NiIsImNsaWVudGlkIjoiYmR1YXQyazM4NiJ9.eyJtZXJjaWQiOiJCRFVBVDJLMzg2Iiwib3JkZXJpZCI6InRlc3Q0YjBmZGVlYzc5MDA5IiwiYW1vdW50IjoiMS4wMCIsIm9yZGVyX2RhdGUiOiIyMDI0LTExLTE1VDE2OjIwOjE4KzA1OjMwIiwiY3VycmVuY3kiOiIzNTYiLCJydSI6Imh0dHBzOi8vdWF0MS5iaWxsZGVzay5jb20iLCJhZGRpdGlvbmFsX2luZm8iOnsiYWRkaXRpb25hbF9pbmZvMSI6IkJpbGxkZXNrIiwiYWRkaXRpb25hbF9pbmZvMiI6IlRlc3QgUGF5bWVudCIsImFkZGl0aW9uYWxfaW5mbzMiOiJ0ZXN0QGdtYWlsLmNvbSIsImFkZGl0aW9uYWxfaW5mbzQiOiJOQSIsImFkZGl0aW9uYWxfaW5mbzUiOiJOQSIsImFkZGl0aW9uYWxfaW5mbzYiOiJOQSIsImFkZGl0aW9uYWxfaW5mbzciOiJOQSJ9LCJpdGVtY29kZSI6IkRJUkVDVCIsImRldmljZSI6eyJpbml0X2NoYW5uZWwiOiJpbnRlcm5ldCIsImlwIjoiNjguMTgzLjk0LjkwIiwidXNlcl9hZ2VudCI6Ik1vemlsbGEvNS4wIChXaW5kb3dzIE5UIDEwLjA7IFdPVzY0KSIsImFjY2VwdF9oZWFkZXIiOiJ0ZXh0L2h0bWwifX0.deOUnKFAKFvMAL7hEthPRXQKl10aGU2f4_fkr2Qay8A';
    
        $response = Http::withHeaders($headers)
    ->withBody($body, 'application/json')
    ->post($url);
    
         return $response->json();
        
    }
    
    function gettranscationdetails(Request $request)
    {
        $order_id = $request->input('orderid');
        $mercid = $request->input('merchid');
        //$transaction_id = $request->input('transactionid');
        
        $gettransurl = "https://uat1.billdesk.com/u2/payments/ve1_2/transactions/get";
        $merchantKey = "deliqOW9hvX8bK9tsRGe8UkoU4HwZjjN";
        
        $requestPayload = [
            "mercid" => $mercid,
            "orderid" => $order_id,
            "refund_details" => "false"
        ];
        
        // Generate HMAC Signature
        $signature = $this->generateHmacSignature($requestPayload, $merchantKey);
        
        // Add to Authorization Header
        $headers = [
            "Content-Type" => "application/jose",
            "Accept" => "application/jose",
            "BD-Timestamp" => time(),
            "BD-Traceid" => uniqid()
        ];
        
        $response = Http::withHeaders($headers)->withBody($signature, 'application/jose')->post($gettransurl);
      
        if ($response->successful()) {
            $responseData = $response->body();
            $tokenParts = explode('.', $responseData);
            $header = json_decode(base64_decode($tokenParts[0]), true); 
            $payload = json_decode(base64_decode($tokenParts[1]), true);
            return $payload;
        }
            
        
        
    }
    
    
    function refundtrans(Request $request)
    {
        $mercid = $request->input('mercid');
        $transaction_id = $request->input('transactionid');
        $transaction_date = $request->input('transaction_date');
        $txn_amount = $request->input('txn_amount');
        $orderid = $request->input('orderid');
        $refund_amount = $request->input('refund_amount');
        $currency = $request->input('currency');
        $merc_refund_ref_no = $request->input('merc_refund_ref_no');
        $merchantKey = "deliqOW9hvX8bK9tsRGe8UkoU4HwZjjN";
        
         $requestPayload = [
            "mercid" => $mercid,
            "transactionid" => $transaction_id,
            "transaction_date" => $transaction_date,
            "txn_amount" => $txn_amount,
            "orderid" => $orderid,
            "refund_amount" => $refund_amount,
            "currency" => $currency,
            "merc_refund_ref_no" => $merc_refund_ref_no,
        ];
        
        // Generate HMAC Signature
        $signature = $this->generateHmacSignature($requestPayload, $merchantKey);
        
        $refundurl = "https://uat1.billdesk.com/u2/payments/ve1_2/refunds/create";
        
        // Add to Authorization Header
        $headers = [
            "Content-Type" => "application/jose",
            "Accept" => "application/jose",
            "BD-Timestamp" => time(),
            "BD-Traceid" => uniqid()
        ];
        
        $response = Http::withHeaders($headers)->withBody($signature, 'application/jose')->post($refundurl);
        return $response;
        if ($response->successful()) {
            $responseData = $response->body();
            $tokenParts = explode('.', $responseData);
            $header = json_decode(base64_decode($tokenParts[0]), true); 
            $payload = json_decode(base64_decode($tokenParts[1]), true);
            return $payload;
        }
    }
}
