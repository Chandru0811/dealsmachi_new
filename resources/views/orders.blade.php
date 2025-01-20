@extends('layouts.master')

@section('content')
<div class="container categoryIcons p-3">
    <div class="d-flex justify-content-between mb-3">
        <h3 style="color: #ff0060">
            My Orders
            @if($orders->isNotEmpty())
                ({{ $orders->sum(function ($order) { return $order->items->count(); }) }})
            @endif
        </h3>
        <a href="/" class="text-decoration-none">
            <button type="button" class="btn showmoreBtn">
                Shop more
            </button>
        </a>
    </div>
    @if ($orders->isNotEmpty())
    @foreach ($orders as $order)
        @foreach ($order->items as $item)
        <a class="text-decoration-none" href="{{ url('order', ['id' => $order->id, 'product_id' => $item->product_id]) }}">
            <div class="card orderCard p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <p>
                        Order Id: <span>{{ $order->order_number ?? 'N/A' }}</span>&nbsp;
                        <span class="badge_payment">{{
                            $order->status === "1" ? "Created" :
                            ($order->status === "2" ? "Payment Error" :
                            ($order->status === "3" ? "Confirmed" :
                            ($order->status === "4" ? "Awaiting Delivery" :
                            ($order->status === "5" ? "Delivered" :
                            ($order->status === "6" ? "Returned" :
                            ($order->status === "7" ? "Cancelled" : "Unknown Status"))))))
                        }}</span>&nbsp;
                        <span class="badge_warning">
                            {{ $item->deal_type == 1 ? 'Product' : ($item->deal_type == 2 ? 'Service' : '') }}
                        </span>
                    </p>
                    <div class="d-flex">
                        <p>Date : <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</span></p>
                        &nbsp;&nbsp;
                        {{-- <p>Time : <span>{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</span></p> --}}
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-start">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-12">
                            @php
                                $image = $item->product->productMedia
                                    ->where('order', 1)
                                    ->where('type', 'image')
                                    ->first();
                            @endphp
                            <img
                                src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                class="img-fluid"
                                alt="{{ $item->product->name }}" />
                        </div>
                        <div class="col-lg-9 col-md-9 col-12">
                            <p class="mb-1">
                                {{ $item->item_description?? 'No Name Available' }}
                            </p>
                            <p class="mb-1 truncated-description">
                                {{ $item->product->description ?? 'No Description Available' }}
                            </p>
                            <div class="d-flex">
                                @if($item->deal_type === '1' || $item->deal_type === 'Product')
                                <p class="mt-1 mb-0">Quantity : {{ $item->quantity }}</p> &nbsp;&nbsp;&nbsp;
                                @endif
                                @if ($item->deal_type === '1' || $item->deal_type === 'Product')
                                <p class="mt-1 mb-0">Delivery Date:
                                    {{ \Carbon\Carbon::parse($order->created_at)->addDays(5)->format('d/m/Y') ?? 'N/A' }}
                                </p>
                                @else
                                @endif
                            </div>
                            <p>
                                <del>₹{{ number_format($item->unit_price * $item->quantity, 2) }}</del> &nbsp;
                                <span style="color: #ff0060; font-size:24px">
                                    ₹{{ number_format($item->discount * $item->quantity, 2) }}
                                </span> &nbsp;
                                <span class="badge_payment">{{ number_format($item->discount_percent, 0) }}% saved</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <span class="badge_warning">{{ ucfirst(str_replace('_', ' ', $order->payment_type ?? 'N/A')) }}</span>
                </div>
            </div>
        </a>
        @endforeach
    @endforeach
    @else
    <p>No orders available.</p>
    @endif
</div>
@endsection
