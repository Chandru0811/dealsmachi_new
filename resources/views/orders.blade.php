@extends('layouts.master')

@section('content')
<div class="container categoryIcons p-3">
    <div class="d-flex justify-content-between mb-3">
    <h3 style="color: #ff0060">
        My Orders
        @if($orders_count > 0)
        ({{ $orders_count }})
        @endif
    </h3>
    <a href="/" class="text-decoration-none">
    <button type="button" class="btn showmoreBtn">
        Show more
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
                    <span class="badge_payment">{{ ucfirst($order->status ?? 'N/A') }}</span>&nbsp;
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
                        <img src="{{ asset($order->items->first()->product->image_url1 ?? 'assets/images/home/noImage.png') }}"
                            alt="{{ $order->items->first()->product->name ?? 'No Product Available' }}" class="img-fluid" />
                    </div>
                    <div class="col-lg-9 col-md-9 col-12">
                        <p class="mb-1">
                            @foreach ($order->items as $item)
                            {{ $item->product->name ?? 'No Product Name Available' }}
                        </p>
                        <p class="mb-1">
                            {{ $item->product->description ?? 'No Product Description Available' }}
                        </p>
                        <p>
                            @if($item->product)
                            <del class="original-price">{{ $item->product->original_price }}</del> &nbsp;
                            <span class="discounted-price" style="color: #ff0060; font-size:24px">
                                {{ $item->product->discounted_price }}
                            </span> &nbsp;
                            <span class="badge_payment">{{ number_format($item->product->discount_percentage, 0) }}%
                                saved</span>
                            @else
                            <span class="original-price">-</span>
                            <span class="discounted-price" style="color: #ff0060; font-size:24px">-</span>&nbsp;
                            <span class="badge_payment">-%</span>
                            @endif
                        </p>
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