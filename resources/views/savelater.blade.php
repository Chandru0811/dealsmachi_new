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
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ff0060; color:#fff">
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
            style="position: fixed; top: 70px; right: 40px; z-index: 1050; background:#ff0060; color:#fff">
            {{ session('error') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <section>
        <div class="container" style="margin-top: 100px">
            <h2 class="my-4">Saved Later</h2>
            @if ($savedItems->isEmpty())
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/images/home/empty_savedItems.png') }}" alt="Empty Cart"
                        class="img-fluid mb-2" style="width: 300px;" />
                    <h4 style="color: #ff0060;">Your Saved Wishlists are awaiting your selection!</h4>
                </div>
            @else
                <hr>
                @foreach ($savedItems as $savedItem)
                    <div class="row p-4">
                        <div class="col-md-3 d-flex flex-column justify-content-center align-items-center">
                            <div class="d-flex justify-content-center align-items-center">
                                @php
                                $image = isset($savedItem->deal->productMedia)
                                    ? $savedItem->deal->productMedia
                                    ->where('order', 1)
                                    ->where('type', 'image')
                                    ->first() : null;
                            @endphp
                                <img
                                    src="{{ $image ? asset($image->path) : asset('assets/images/home/noImage.webp') }}"
                                    style="max-width: 100%; max-height: 100%;"
                                    alt="{{ $savedItem->deal->name }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>{{ $savedItem->deal->name }}</h5>
                            <h6 class="truncated-description">{{ $savedItem->deal->description }}</h6>
                            <p class="mb-1">Delivery Date :</p>
                            <p>Seller : {{ $savedItem->deal->shop->email }}</p>
                            <div>
                                <span style="text-decoration: line-through; color:#c7c7c7">
                                    ₹{{ $savedItem->deal->original_price }}
                                </span>
                                <span class="ms-1" style="font-size:22px;color:#ff0060">
                                    ₹{{ $savedItem->deal->discounted_price }}
                                </span>
                                <span class="ms-1" style="font-size:12px; color:#00DD21">
                                    {{ round($savedItem->deal->discount_percentage) }}% off
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex flex-column justify-content-end align-items-end mb-3">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <form action="{{ route('movetocart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $savedItem->deal_id }}">
                                    <button type="submit" class="btn border btn-outline-secondary"
                                        style="padding: 14px 20px; border-top-right-radius: 0px; border-bottom-right-radius: 0px;">
                                        Move to Cart
                                    </button>
                                </form>
                                <form action="{{ route('savelater.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $savedItem->deal_id }}">
                                    <button type="submit" class="btn border btn-outline-secondary"
                                        style="padding: 14px 20px; border-top-left-radius: 0px; border-bottom-left-radius: 0px;">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr class="mt-3">
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection
