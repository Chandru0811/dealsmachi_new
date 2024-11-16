@extends('layouts.master')

@section('content')
    <div class="container categoryIcons p-3">
        <div>
            <div class="d-flex align-items-center mb-4">
                <h4 class="text-dark order_id">
                    Order ID: <span>{{ $order->order_number }}</span>&nbsp;
                </h4>
                <span class="badge_warning">
                    {{ $order->status ?? 'N/A' }}
                </span>
                <span class="{{ $order->order_type === 'service' ? 'badge_default' : 'badge_payment' }}">
                    {{ $order->order_type ?? 'N/A' }}
                </span>
            </div>

            <div class="row">
                {{-- Left Column: Order Item & Order Summary --}}
                <div class="col-md-8">
                    {{-- Order Item --}}
                    <div class="card mb-4">
                        <div class="card-header m-0 p-2 d-flex gap-2 align-items-center" style="background: #ffecee">
                            <p class="mb-0">Order Item</p>
                            <span class="badge_danger">{{ $order->status ?? 'N/A' }}</span>
                            @if ($order->items && count($order->items) > 0 && $order->items[0]->product->coupon_code)
                                <span class="badge_payment">{{ $order->items[0]->product->coupon_code }}</span>
                            @endif
                        </div>
                        <div class="card-body m-0 p-4">
                            @foreach ($order->items as $item)
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <img src="{{ asset($item->product->image_url1) }}" alt="{{ $item->product->name }}"
                                            class="img-fluid" />
                                    </div>
                                    <div class="col">
                                        <p>
                                            {{ $item->product->name }}</p>
                                        <p>{{ $item->product->description }}</p>
                                        <p>
                                            <del>₹
                                                {{ number_format($item->product->original_price, 0) }}</del>&nbsp;&nbsp;
                                            <span style="color: #dc3545; font-size:24px">₹
                                                {{ number_format($item->product->discounted_price, 0) }}</span>&nbsp;&nbsp;
                                            <span
                                                class="badge_danger">{{ number_format($item->product->discount_percentage, 0) }}%
                                                saved</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    @if ($order->order_type === 'service')
                                        <div class="d-flex gap-4">
                                            <p>Service Date: {{ $order->service_date ?? ' ' }}</p>
                                            <p>Service Time: {{ $order->service_time ?? ' ' }}</p>
                                        </div>
                                    @else
                                        <div class="d-flex gap-4">
                                            <p>Quantity: {{ $order->quantity ?? ' ' }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shop Details --}}
                    <div class="card mb-4">
                        <div class="card-header m-0 p-2 d-flex gap-2 align-items-center" style="background: #ffecee">
                            <p class="mb-0">Shop Details</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            @if ($order->shop)
                                <div class="row align-items-center mb-3">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p>Company Name</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $order->shop->legal_name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Company Email</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $order->shop->email ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Company Mobile</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $order->shop->mobile ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Description</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $order->shop->description ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Address</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $order->shop->street ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>No Shop Details Available</p>
                            @endif
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="card">
                        <div class="card-header m-0 p-2 d-flex justify-content-between align-items-center"
                            style="background: #ffecee">
                            <p class="mb-0">Order Summary</p>
                            <p>
                                <span
                                    class="{{ $order->payment_type === 'online_payment' ? 'badge_default' : 'badge_payment' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_type ?? 'Pending')) }}
                                </span>&nbsp;
                                <span class="badge_warning">{{ $order->payment_status ?? 'Pending' }}</span>
                            </p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <div class="d-flex justify-content-between">
                                <span>Unit Price</span>
                                <span>₹ {{ number_format($order->items[0]->unit_price ?? 0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>₹ {{ number_format($order->total, 2) }}</span>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between pb-3">
                                <span>Total</span>
                                <span>₹ {{ number_format($order->total, 2) }}</span>
                            </div>
                            {{-- <div class="d-flex align-items-center gap-1">
                                <button class="badge_outline_dark">Send Invoice</button>
                                <button class="badge_outline_pink">Collect Payment</button>
                            </div> --}}
                        </div>
                    </div>
                </div>

                {{-- Right Column: Notes, Customer Info, Contact, and Address --}}
                <div class="col-md-4">
                    {{-- Notes --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Notes</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>{{ $order->notes ?? 'No notes available' }}</p>
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Customer</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>Name : {{ $order->first_name }} {{ $order->last_name ?? '' }}</p>
                            <p>Email : {{ $order->email ?? 'No Email provided' }}</p>
                        </div>
                    </div>

                    {{-- Contact Information --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Contact Information</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>Name : {{ $order->customer->name ?? 'N/A' }}</p>
                            <p>Email : {{ $order->customer->email ?? 'N/A' }}</p>
                            <p>Phone : {{ $order->mobile ?? 'No phone number provided' }}</p>
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>Shipping : {{ $order->shipping_address ?? 'No shipping address provided' }}</p>
                            <p>Billing : {{ $order->billing_address ?? 'No billing address provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
