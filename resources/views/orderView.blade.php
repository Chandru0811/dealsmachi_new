@extends('layouts.master')

@section('content')
    @if (session('status'))
        <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#00e888; color:#fff">
            {!! nl2br(e(session('status'))) !!}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ef4444; color:#fff">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-dismissible fade show" role="alert"
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ef4444; color:#fff">
            {{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($order)
        <div class="container categoryIcons p-3">
            <div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="text-dark order_id">
                            Order ID: <span>{{ $order->order_number }}</span>&nbsp;
                        </h4>
                        <span class="badge_warning">
                            {{ $order->payment_status === '1'
                                ? 'Not Paid'
                                : ($order->payment_status === '2'
                                    ? 'Pending'
                                    : ($order->payment_status === '3'
                                        ? 'Paid'
                                        : ($order->payment_status === '4'
                                            ? 'Refund Initiated'
                                            : ($order->payment_status === '5'
                                                ? 'Refunded'
                                                : ($order->payment_status === '6'
                                                    ? 'Refund Error'
                                                    : 'Unknown Status'))))) }}
                        </span>
                        <span class="{{ $order->order_type === 'service' ? 'badge_default' : 'badge_payment' }}">
                            {{ $order->items[0]->deal_type == 1 ? 'Product' : ($order->items[0]->deal_type == 2 ? 'Service' : '') }}
                        </span>
                    </div>
                    {{-- <a href="{{ route('order.invoice', $order->id) }}" class="text-decoration-none pe-2">
                            <button type="button" class="btn invoiceBtn" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Download Invoice"><i class="fa-solid fa-file-invoice"></i></button>
                        </a> --}}
                    @if (isset($order->items[0]->product->slug) && $order->items[0]->product->slug)
                        <form action="{{ route('cart.add', ['slug' => $order->items[0]->product->slug]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="saveoption" id="saveoption" value="buy now">
                            <button type="submit" class="btn showmoreBtn">Order again</button>
                        </form>
                    @endif
                </div>
                <div class="row">
                    {{-- Left Column: Order Item & Order Summary --}}
                    <div class="col-md-8">
                        {{-- Order Item --}}
                        <div class="card mb-4">
                            <div class="card-header m-0 p-2 d-flex gap-2 align-items-center justify-content-between"
                                style="background: #ffecee">
                                <p class="mb-0">
                                    <span>Order Item</span>
                                    <span class="badge_danger">
                                        {{ $order->status === '1'
                                            ? 'Created'
                                            : ($order->status === '2'
                                                ? 'Payment Error'
                                                : ($order->status === '3'
                                                    ? 'Confirmed'
                                                    : ($order->status === '4'
                                                        ? 'Awaiting Delivery'
                                                        : ($order->status === '5'
                                                            ? 'Delivered'
                                                            : ($order->status === '6'
                                                                ? 'Returned'
                                                                : ($order->status === '7'
                                                                    ? 'Cancelled'
                                                                    : 'Unknown Status')))))) }}
                                    </span>
                                    @if ($order->items[0]->coupon_code == null)
                                        <span class="badge_payment">No Coupon Code</span>
                                    @else
                                        <span class="badge_payment">{{ $order->items[0]->coupon_code }}</span>
                                    @endif
                                </p>
                                <p class="mb-0">
                                    <span>Date :
                                        <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</span></span>
                                    &nbsp;&nbsp;
                                    {{-- <span>Time :
                                        <span>{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</span></span> --}}
                                </p>
                            </div>
                            <div class="card-body m-0 p-4">
                                @foreach ($order->items as $item)
                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-3">
                                            @php
                                                $image = $item->product->productMedia
                                                    ->where('order', 1)
                                                    ->where('type', 'image')
                                                    ->first();
                                            @endphp
                                            <img src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                                class="img-fluid" alt="{{ $item->product->name }}" />
                                        </div>
                                        <div class="col">
                                            @if ($item->order_id)
                                                @if (isset($order->items[0]->product) &&
                                                        !($order->items[0]->product->active == 0 || $order->items[0]->product->deleted_at != null))
                                                    <a href="{{ url('/deal/' . $order->items[0]->product_id) }}"
                                                        style="color: #000;"
                                                        onclick="clickCount('{{ $order->items[0]->deal_id }}')">
                                                        <p style="font-size: 24px;">
                                                            {{ $item->item_description }}
                                                        </p>
                                                    </a>
                                                @else
                                                    <p style="font-size: 24px; color: #000; text-decoration: none;">
                                                        {{ $item->item_description }}
                                                    </p>
                                                @endif
                                                <p class="truncated-description">{{ $item->product->description }}</p>
                                                <p class="mb-0">
                                                    <del>₹{{ number_format($item->unit_price, 2) }}</del>
                                                    &nbsp;&nbsp;
                                                    <span
                                                        style="color:#ff0060; font-size:24px">₹{{ number_format($item->discount, 2) }}</span>
                                                    &nbsp;&nbsp;
                                                    <span
                                                        class="badge_danger">{{ number_format($item->discount_percent, 0) }}%
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
                                        @foreach ($order->items as $item)
                                            @if ($item->deal_type === '2')
                                                <div class="d-flex gap-4">
                                                    <p>Service Date: {{ $item->service_date ?? 'N/A' }}</p>
                                                    <p>Service Time:
                                                        {{ \Carbon\Carbon::parse($item->service_time)->format('h:i A') ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="d-flex gap-4">
                                                    <p>Quantity: {{ $item->quantity ?? ' ' }}</p>
                                                </div>
                                            @endif
                                        @endforeach
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
                                @if ($order->items->isNotEmpty() && $order->items->first()->shop)
                                    <p>Company Name : {{ $order->items->first()->shop->name ?? 'N/A' }}</p>
                                    <p>Company Email : {{ $order->items->first()->shop->email ?? 'N/A' }}</p>
                                    <p>Company Mobile : {{ $order->items->first()->shop->mobile ?? 'N/A' }}</p>
                                    <p>Description : {{ $order->items->first()->shop->description ?? 'N/A' }}</p>
                                    <p>
                                        Address:
                                        @if ($order->items->first()->shop->street)
                                            {{ $order->items->first()->shop->street }}
                                        @endif
                                        @if ($order->items->first()->shop->city)
                                            , {{ $order->items->first()->shop->city }}
                                        @endif
                                        @if ($order->items->first()->shop->zip_code)
                                            , {{ $order->items->first()->shop->zip_code }}
                                        @endif
                                    </p>
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
                                    <span
                                        class="badge_warning">{{ $order->payment_status === '1'
                                            ? 'Not Paid'
                                            : ($order->payment_status === '2'
                                                ? 'Pending'
                                                : ($order->payment_status === '3'
                                                    ? 'Paid'
                                                    : ($order->payment_status === '4'
                                                        ? 'Refund Initiated'
                                                        : ($order->payment_status === '5'
                                                            ? 'Refunded'
                                                            : ($order->payment_status === '6'
                                                                ? 'Refund Error'
                                                                : 'Unknown Status'))))) }}</span>
                                </p>
                            </div>
                            <div class="card-body m-0 p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal
                                        @if ($item->quantity != 1)
                                            (x{{ $item->quantity }})
                                        @endif
                                    </span>
                                    <span id="subtotal"></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Discount
                                        @if ($item->quantity != 1)
                                            (x{{ $item->quantity }})
                                        @endif
                                    </span>
                                    <span id="discount"></span>
                                </div>
                                <hr />
                                <div class="d-flex justify-content-between pb-3">
                                    <span>Total
                                        @if ($item->quantity != 1)
                                            (x{{ $item->quantity }})
                                        @endif
                                    </span>
                                    <span id="total"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Right Column: Notes, Customer Info, Contact, and Address --}}
                    <div class="col-md-4">
                        {{-- Notes {{--
                      {{--  <div class="card mb-4">
                            <div class="card-header m-0 p-2" style="background: #ffecee">
                                <p class="mb-0">Notes</p>
                            </div>
                            <div class="card-body m-0 p-4">
                                <p>{{ $order->items->first()?->item_description ?? 'No notes available' }}</p>
                            </div>
                        </div> --}}
                        {{-- Contact Information --}}
                        <div class="card mb-4">
                            <div class="card-header m-0 p-2" style="background: #ffecee">
                                <p class="mb-0">Contact Information</p>
                            </div>
                            <div class="card-body m-0 p-4">
                                <p>Name : {{ $order->customer->name ?? 'N/A' }}</p>
                                <p>Email : {{ $order->customer->email ?? 'N/A' }}</p>
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
                                @if ($order->address)
                                    <p>Name : {{ $order->address->first_name ?? '' }}
                                        {{ $order->address->last_name ?? '' }}</p>
                                    <p>Email : {{ $order->address->email ?? 'N/A' }}</p>
                                    <p>Phone : {{ $order->address->phone ?? 'No phone number provided' }}</p>
                                    <p>Address :
                                        {{ $order->address->address ?? '--' }},
                                        {{ $order->address->postalcode ?? '--' }}
                                    </p>
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
        <div class="col-12 d-flex justify-content-center align-items-center text-center" style="min-height: 75vh;">
            <div class="col-12 col-md-12" style="color: rgb(128, 128, 128);">
                <h4>Oh no! We couldn't find the order you're looking for.</h4>
                <p style="margin-top: 10px; font-size: 14px;">Please check the order ID and try again.</p>
                <a href="{{ url('/') }}" style="color: #007BFF; text-decoration: underline;">Back to
                    Home</a>
            </div>
        </div>
    @endif
    <script>
        @if ($order)
            const orderItems = @json($order->items);

            let subtotal = orderItems.reduce((sum, item) => sum + (parseFloat(item.unit_price) * item.quantity), 0);
            let total = orderItems.reduce((sum, item) => sum + (parseFloat(item.discount) * item.quantity), 0);
            let discount = subtotal - total;

            document.getElementById('subtotal').innerText = `₹${subtotal.toFixed(2)}`;
            document.getElementById('discount').innerText = `₹${discount.toFixed(2)}`;
            document.getElementById('total').innerText = `₹${total.toFixed(2)}`;
        @endif
    </script>
@endsection
