@extends('layouts.master')

@section('content')
<div class="container categoryIcons p-3">
    <div class="d-flex justify-content-between mb-3">
        <h3 style="color: #ff0060">
            My Orders
            @if(count($orders) > 0)
            ({{ count($orders) }})
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
    <a class="text-decoration-none" href="{{ url('orders', ['id' => $order->id]) }}">
        <div class="card p-3 mb-3">
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
                    @if ($order->coupon_applied)
                    <span class="badge_warning">
                        {{ ucfirst($order->order_type ?? 'N/A') }}
                    </span>
                    @endif
                </p>
                <p>Date: <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</span></p>
            </div>
            <div class="d-flex justify-content-between align-items-start">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <img src="{{ asset($order->items->first()->product->image_url1 ?? 'assets/images/home/noImage.webp') }}"
                            alt="{{ $order->items->first()->product->name ?? 'No Product Available' }}"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/home/noImage.webp') }}';"
                            class="img-fluid" />
                    </div>
                    <div class="col-lg-9 col-md-9 col-12">
                        @foreach ($order->items as $item)
                        @if ($item)
                        <p class="mb-1">
                            {{ $item->deal_name }}
                        </p>
                        <p class="mb-1 descTruncate">
                            {{ $item->deal_description }}
                        </p>
                        @if($order->order_type === 'product')
                        <p class="mt-1 mb-0">Quantity : {{ $item->quantity }}</p>
                        @endif
                        <p>
                            <del class="original-price">{{ $item->deal_originalprice * $item->quantity }}</del> &nbsp;
                            <span class="discounted-price" style="color: #ff0060; font-size:24px">
                                {{ $item->deal_price * $item->quantity }}
                            </span> &nbsp;
                            <span class="badge_payment">{{ number_format($item->discount_percentage, 0) }}%
                                saved</span>
                        </p>
                        @else
                        <div class="nodata">No Product Data Available!</div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                <span class="badge_warning">{{ ucfirst(str_replace('_', ' ', $order->payment_type ?? 'N/A')) }}</span>
            </div>
        </div>
    </a>
    @endforeach
    @else
    <p>No orders available.</p>
    @endif
</div>
@endsection