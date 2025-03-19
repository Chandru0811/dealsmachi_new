<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {

        Log::channel('payment')->info('Payment Webhook Received', [
            'headers' => $request->headers->all(),
            'body' => $request->getContent(),
        ]);

        if ($request->header('Content-Type') === 'application/jose') {
            $data = json_decode($request->getContent(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return Response::json(['error' => 'Invalid JSON format'], 400);
            }
        } else {
            $data = $request->all();
        }

        if (empty($data)) {
            return response()->json(['error' => 'No data received'], 400);
        }

        return response()->json(['message' => 'Webhook received'], 200);
    }
}
