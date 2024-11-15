@extends('layouts.master')

@section('content')
    @php
        $data = (object) [
            'payment_status' => 'pending',
            'order_type' => 'product', // or 'service'
            'status' => 'Completed',
            'items' => [
                (object) [
                    'product' => (object) [
                        'name' => 'Sample Product',
                        'description' => 'This is a sample product description.',
                        'original_price' => 1500,
                        'discounted_price' => 1200,
                        'discount_percentage' => 20,
                        'image_url1' => null,
                        'coupon_code' => 'DEAL2023',
                    ],
                    'unit_price' => 1200,
                ],
            ],
            'quantity' => 1,
            'service_date' => '2024-12-01',
            'service_time' => '10:00 AM',
            'shop' => (object) [
                'legal_name' => 'Sample Shop',
                'email' => 'shop@example.com',
                'mobile' => '1234567890',
                'description' => 'A great place to shop!',
                'street' => '123 Main St',
            ],
            'total' => 1200,
            'payment_type' => 'online_payment',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'customer' => (object) [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
            ],
            'mobile' => '9876543210',
            'shipping_address' => '123 Shipping Ln',
            'billing_address' => '123 Billing Blvd',
            'notes' => 'Leave package at the door.',
        ];
    @endphp

    <div class="container categoryIcons p-3">
        <div>
            <div class="d-flex align-items-center mb-4">
                <h4 class="text-dark order_id">
                    Order ID: DEALSLAH_002&nbsp;
                </h4>
                <span class="badge_warning">
                    {{ $data->payment_status ?? 'N/A' }}
                </span>
                <span class="{{ $data->order_type === 'service' ? 'badge_default' : 'badge_payment' }}">
                    {{ $data->order_type ?? 'N/A' }}
                </span>
            </div>

            <div class="row">
                {{-- Left Column: Order Item & Order Summary --}}
                <div class="col-md-8">
                    {{-- Order Item --}}
                    <div class="card mb-4">
                        <div class="card-header m-0 p-2 d-flex gap-2 align-items-center" style="background: #ffecee">
                            <p class="mb-0">Order Item</p>
                            <span class="badge_danger">{{ $data->status ?? 'N/A' }}</span>
                            @if ($data->items && count($data->items) > 0 && $data->items[0]->product->coupon_code)
                                <span class="badge_payment">{{ $data->items[0]->product->coupon_code }}</span>
                            @endif
                        </div>
                        <div class="card-body m-0 p-4">
                            @foreach ($data->items as $item)
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <img src="{{ $item->product->image_url1 ? asset($item->product->image_url1) : asset('noImage.png') }}"
                                            alt="{{ $item->product->name }}" style="width: 100%;" />
                                    </div>
                                    <div class="col">
                                        <p>{{ $item->product->category_id ?? 'Category' }} :
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
                                    @if ($data->order_type === 'service')
                                        <div class="d-flex gap-4">
                                            <p>Service Date: {{ $data->service_date ?? ' ' }}</p>
                                            <p>Service Time: {{ $data->service_time ?? ' ' }}</p>
                                        </div>
                                    @else
                                        <div class="d-flex gap-4">
                                            <p>Quantity: {{ $data->quantity ?? ' ' }}</p>
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
                            @if ($data->shop)
                                <div class="row align-items-center mb-3">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p>Company Name</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $data->shop->legal_name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Company Email</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $data->shop->email ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Company Mobile</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $data->shop->mobile ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Description</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $data->shop->description ?? 'N/A' }}</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p>Address</p>
                                            </div>
                                            <div class="col-md-9">
                                                <p>: {{ $data->shop->street ?? 'N/A' }}</p>
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
                                    class="{{ $data->payment_type === 'online_payment' ? 'badge_default' : 'badge_payment' }}">
                                    {{ ucfirst(str_replace('_', ' ', $data->payment_type ?? 'Pending')) }}
                                </span>&nbsp;
                                <span class="badge_warning">{{ $data->payment_status ?? 'Pending' }}</span>
                            </p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <div class="d-flex justify-content-between">
                                <span>Unit Price</span>
                                <span>₹ {{ number_format($data->items[0]->unit_price ?? 0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>₹ {{ number_format($data->total, 2) }}</span>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between pb-3">
                                <span>Total</span>
                                <span>₹ {{ number_format($data->total, 2) }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button class="badge_outline_dark">Send Invoice</button>
                                <button class="badge_outline_pink">Collect Payment</button>
                            </div>
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
                            <p>{{ $data->notes ?? 'No notes available' }}</p>
                        </div>
                    </div>

                    {{-- Customer Info --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Customer</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>Name : {{ $data->first_name }} {{ $data->last_name ?? '' }}</p>
                            <p>Email : {{ $data->email ?? 'No Email provided' }}</p>
                        </div>
                    </div>

                    {{-- Contact Information --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Contact Information</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>Name : {{ $data->customer->name ?? 'N/A' }}</p>
                            <p>Email : {{ $data->customer->email ?? 'N/A' }}</p>
                            <p>Phone : {{ $data->mobile ?? 'No phone number provided' }}</p>
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    <div class="card mb-2">
                        <div class="card-header m-0 p-2" style="background: #ffecee">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <p>Shipping : {{ $data->shipping_address ?? 'No shipping address provided' }}</p>
                            <p>Billing : {{ $data->billing_address ?? 'No billing address provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
