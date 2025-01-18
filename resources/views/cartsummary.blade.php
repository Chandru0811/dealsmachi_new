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
    @endif.
    @php
        $selectedAddressId = session('selectedId');
        $default_address =
            $addresses->firstWhere('id', $selectedAddressId) ?? ($addresses->firstWhere('default', true) ?? null); // Add fallback to null
    @endphp

    @php
        $subtotal = 0;
        $total_discount = 0;
    @endphp
    <section>
        <div class="container" style="margin-top: 100px">
            <div class="row">
                <div class="col-12">
                    <p class="text-center mb-0" style="visibility: hidden">p</p>

                    <div class="card p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <h5 class="fw-bold mb-0">Delivery Addresses</h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            @if ($default_address)
                                <span class="badge badge_infos py-1" data-bs-toggle="modal"
                                    data-bs-target="#myAddressModal">Change</span>
                            @else
                                <button type="button" class="btn primary_new_btn" style="font-size: 12px"
                                    data-bs-toggle="modal" data-bs-target="#newAddressModal">
                                    <i class="fa-light fa-plus"></i> Add New Address
                                </button>
                            @endif
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                @if ($default_address)
                                    <p>
                                        <strong>{{ $default_address->first_name ?? '' }}
                                            {{ $default_address->last_name ?? '' }} (+65)
                                            {{ $default_address->phone ?? '' }}</strong>&nbsp;&nbsp;<br>
                                        {{ $default_address->address ?? '' }} -
                                        {{ $default_address->postalcode ?? '' }}
                                        <span>
                                            @if ($default_address->default)
                                                <span class="badge badge_danger py-1">Default</span>&nbsp;&nbsp;
                                            @endif
                                        </span>
                                    </p>
                                @else
                                    <p class="font-weight-bold">Uh-oh! It looks like you don't have a default
                                        address set yet. Add one now to speed up your checkout process!</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        @foreach ($carts->items as $item)
                            @php
                                $product = $item->product;
                                $subtotal += $product->original_price * $item->quantity;
                                $total_discount +=
                                    ($product->original_price - $product->discounted_price) * $item->quantity;
                            @endphp
                            <div class="row px-4 pt-4">
                                <div class="col-md-3 d-flex flex-column justify-content-center align-items-center">
                                    <div class="bg-light d-flex justify-content-center align-items-center"
                                        style="border: 1px solid #ddd;">
                                        <img src="{{ asset($product->image_url1) }}" alt="{{ $product->name }}"
                                            style="max-width: 100%; max-height: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <h5>{{ $product->name }}</h5>
                                    <h6 class="truncated-description">{{ $product->description }}</h6>
                                    <p class="mb-1">Delivery Date : {{ $product->delivery_date }}</p>
                                    <p>Seller : {{ $product->shop->email ?? '' }}</p>
                                    <div>
                                        <span style="text-decoration: line-through; color:#c7c7c7">
                                            ${{ $product->original_price }}
                                        </span>
                                        <span class="ms-1" style="font-size:22px;color:#ef4444">
                                            ${{ $product->discounted_price }}
                                        </span>
                                        <span class="ms-1" style="font-size:12px; color:#00DD21">
                                            {{ round($product->discount_percentage) }}% off
                                        </span>&nbsp; &nbsp; &nbsp;
                                        @if ($item->deal_type == 1)
                                            <span>Quantity : {{ $item->quantity ?? 1 }}</span>
                                        @else
                                            <span>Date: {{ $item->service_date ?? '--' }}, Time:
                                                {{ $item->service_time ? \Carbon\Carbon::createFromFormat('H:i:s', $item->service_time)->format('h:i A') : '--' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <hr class="mt-2 mb-0">
                            </div>
                        @endforeach
                    </div>
                    <div class="card mb-4">
                        <div class="card-header m-0 p-2">
                            <p class="mb-0">Order Summary</p>
                        </div>
                        <div class="card-body m-0 p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <p>Subtotal</p>
                                <p>${{ $subtotal }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p>Discount</p>
                                <p>${{ $total_discount }}</p>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between pb-3">
                                <span>Total</span>
                                <span>${{ $subtotal - $total_discount }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center p-3">
                            @if ($default_address)
                                <a href="{{ url('/checkout/' . $carts->id . '/' . $default_address->id) }}" class="btn"
                                    style="padding:14px 36px; background:#00DD21; font-size:22px; color:#fff; text-decoration: none;">
                                    Order Now
                                </a>
                            @else
                                <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#newAddressModal"
                                    style="padding:14px 36px; background:#00DD21; font-size:22px; color:#fff; text-decoration: none;">
                                    Order Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
