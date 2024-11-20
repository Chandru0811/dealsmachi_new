@extends('layouts.master')

@section('content')
@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert"
    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
    {{ session('status') }}
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert"
    style="position: fixed; top: 70px; right: 40px; z-index: 1050;">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if($order)
<div class="container categoryIcons p-3">
    <div>
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center mb-4">
                <h4 class="text-dark order_id">
                    Order ID: <span>{{ $order->order_number }}</span>&nbsp;
                </h4>
                <span class="badge_warning">
                    {{
                    $order->payment_status	 === "1" ? "Unpaid" :
                    ($order->payment_status	 === "2" ? "Pending" :
                    ($order->payment_status	 === "3" ? "Paid" :
                    ($order->payment_status	 === "4" ? "Refund Initiated" :
                    ($order->payment_status	 === "5" ? "Refunded" :
                    ($order->payment_status	 === "6" ? "Refund Error" :
                    "Unknown Status")))))
                }}
                </span>
                <span class="{{ $order->order_type === 'service' ? 'badge_default' : 'badge_payment' }}">
                    {{ ucfirst($order->order_type ?? 'N/A') }}
                </span>
            </div>
            <div>
                <a href="{{ route('checkout.direct', $order->items[0]->deal_id) }}" class="text-decoration-none">
                    <button type="button" class="btn showmoreBtn">Order again</button>
                </a>
            </div>
        </div>
        <div class="row">
            {{-- Left Column: Order Item & Order Summary --}}
            <div class="col-md-8">
                {{-- Order Item --}}
                <div class="card mb-4">
                    <div class="card-header m-0 p-2 d-flex gap-2 align-items-center" style="background: #ffecee">
                        <p class="mb-0">Order Item</p>
                        <span class="badge_danger">
                            {{
                                $order->status === "1" ? "Created" :
                                ($order->status === "2" ? "Payment Error" :
                                ($order->status === "3" ? "Confirmed" :
                                ($order->status === "4" ? "Awaiting Delivery" :
                                ($order->status === "5" ? "Delivered" :
                                ($order->status === "6" ? "Returned" :
                                ($order->status === "7" ? "Cancelled" : "Unknown Status"))))))
                            }}
                        </span>
                        @if ($order->items[0]->coupon_code == null)
                        <span class="badge_payment">No Coupon Code</span>
                        @else
                        <span class="badge_payment">{{ $order->items[0]->coupon_code }}</span>
                        @endif
                    </div>
                    <div class="card-body m-0 p-4">
                        @foreach ($order->items as $item)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <img src="{{ asset($item->product->image_url1 ?? 'assets/images/home/.webp') }}"
                                    alt="{{ $item->product->name  ?? 'No Product Name Available' }}"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/images/home/noImage.webp') }}';"
                                    class="img-fluid" />
                            </div>
                            <div class="col">
                                @if ($item->order_id)
                                <a href="{{ url('/deal/' . $order->items[0]->deal_id) }}" style="color: #000;"
                                    onclick="clickCount('{{ $order->items[0]->deal_id }}')">
                                    <p style="font-size: 24px;">
                                        {{ $item->deal_name }}
                                    </p>
                                </a>
                                <p>{{ $item->deal_description }}</p>
                                <p>
                                    <del class="original-price">{{ $item->deal_originalprice }}</del>
                                    &nbsp;&nbsp;
                                    <span class="discounted-price" style="color: #ff0060; font-size:24px">{{ $item->deal_price }}</span>
                                    &nbsp;&nbsp;
                                    <span
                                        class="badge_danger">{{ number_format($item->discount_percentage, 0) }}%
                                        saved
                                    </span>
                                </p>
                                @else
                                <div class="nodata">No Product Data Available!</div>
                                @endif
                            </div>
                        </div>
                        @endforeach

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                @if ($order->order_type === 'service')
                                <div class="d-flex gap-4">
                                    <p>Service Date: {{ $order->service_date ?? ' ' }}</p>
                                    <p>Service Time: {{ \Carbon\Carbon::parse($order->service_time)->format('h:i A') ?? ' ' }}</p>
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
                        <p>Company Name : {{ $order->shop->legal_name ?? 'N/A' }}</p>
                        <p>Company Email : {{ $order->shop->email ?? 'N/A' }}</p>
                        <p>Company Mobile : {{ $order->shop->mobile ?? 'N/A' }}</p>
                        <p>Description : {{ $order->shop->description ?? 'N/A' }}</p>
                        <p>Address : {{ $order->shop->street ?? 'N/A' }}</p>
                        @else
                        <p>No Shop Details Available</p>
                        @endif
                    </div>
                </div>
                {{-- Order Summary --}}
                <div class="card mb-4">
                    <div class="card-header m-0 p-2 d-flex justify-content-between align-items-center"
                        style="background: #ffecee">
                        <p class="mb-0">Order Summary</p>
                        <p>
                            <span
                                class="{{ $order->payment_type === 'online_payment' ? 'badge_default' : 'badge_payment' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_type ?? 'Pending')) }}
                            </span>&nbsp;
                            <span class="badge_warning">{{
                                $order->payment_status	 === "1" ? "Unpaid" :
                                ($order->payment_status	 === "2" ? "Pending" :
                                ($order->payment_status	 === "3" ? "Paid" :
                                ($order->payment_status	 === "4" ? "Refund Initiated" :
                                ($order->payment_status	 === "5" ? "Refunded" :
                                ($order->payment_status	 === "6" ? "Refund Error" :
                                "Unknown Status")))))
                            }}</span>
                        </p>
                    </div>
                    <div class="card-body m-0 p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal
                                @if($order->quantity != 1)
                                (x{{ $order->quantity }})
                                @endif
                            </span>
                            <span id="subtotal"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Discount
                                @if($order->quantity != 1)
                                (x{{ $order->quantity }})
                                @endif
                            </span>
                            <span id="discount"></span>
                        </div>
                        <hr />
                        <div class="d-flex justify-content-between pb-3">
                            <span>Total
                                @if($order->quantity != 1)
                                (x{{ $order->quantity }})
                                @endif
                            </span>
                            <span id="total"></span>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Right Column: Notes, Customer Info, Contact, and Address --}}
            <div class="col-md-4">
                {{-- Notes --}}
                <div class="card mb-4">
                    <div class="card-header m-0 p-2" style="background: #ffecee">
                        <p class="mb-0">Notes</p>
                    </div>
                    <div class="card-body m-0 p-4">
                        <p>{{ $order->notes ?? 'No notes available' }}</p>
                    </div>
                </div>
                {{-- Contact Information --}}
                <div class="card mb-4">
                    <div class="card-header m-0 p-2" style="background: #ffecee">
                        <p class="mb-0">Contact Information</p>
                    </div>
                    <div class="card-body m-0 p-4">
                        <p>Name : {{ $order->first_name . ' ' . $order->last_name ?? 'N/A' }}</p>
                        <p>Email : {{ $order->email ?? 'N/A' }}</p>
                        <p>Phone : {{ $order->mobile ?? 'No phone number provided' }}</p>
                    </div>
                </div>
                {{-- Shipping Address --}}
                @php
                $address = json_decode($order->delivery_address, true);
                @endphp
                <div class="card mb-4">
                    <div class="card-header m-0 p-2" style="background: #ffecee">
                        <p class="mb-0">Address</p>
                    </div>
                    <div class="card-body m-0 p-4">
                        @if($address)
                        <p>{{ $address['street'] ?? '--' }}, {{ $address['city'] ?? '--' }}, {{ $address['state'] ?? '--' }}, {{ $address['country'] ?? '--' }}, {{ $address['zipCode'] ?? '--' }}.</p>
                        @else
                        <p>No address provided</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="col-12 d-flex justify-content-center align-items-center text-center"
    style="min-height: 75vh;">
    <div class="col-12 col-md-12" style="color: rgb(128, 128, 128);">
        <h4>Oh no! We couldn't find the order you're looking for.</h4>
        <p style="margin-top: 10px; font-size: 14px;">Please check the order ID and try again.</p>
        <a href="{{ url('/') }}" style="color: #007BFF; text-decoration: underline;">Back to
            Home</a>
    </div>
</div>
@endif
<script>
    @if($order)
    const orderItems = @json($order -> items);

    let subtotal = orderItems.reduce((sum, item) => sum + (parseFloat(item.deal_originalprice) * item.quantity), 0);
    let total = orderItems.reduce((sum, item) => sum + (parseFloat(item.deal_price) * item.quantity), 0);
    let discount = subtotal - total;

    function formatIndianNumber(number) {
        return new Intl.NumberFormat('en-IN').format(number);
    }

    document.getElementById('subtotal').innerText = `₹${formatIndianNumber(subtotal.toFixed(2))}`;
    document.getElementById('discount').innerText = `₹${formatIndianNumber(discount.toFixed(2))}`;
    document.getElementById('total').innerText = `₹${formatIndianNumber(total.toFixed(2))}`;
    @endif
</script>
@endsection