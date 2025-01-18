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
    @php
        $selectedAddressId = session('selectedAddressId');
        $default_address =
            $addresses->firstWhere('id', $selectedAddressId) ?? ($addresses->firstWhere('default', true) ?? null); // Add fallback to null
    @endphp
    <section>
        <div class="container" style="margin-top: 100px">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-12">
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
                    <div class="card p-3 mb-3">
                        @foreach ($products as $product)
                            <div class="row px-4 pt-2">
                                <div class="col-md-4 col-12 d-flex flex-column justify-content-center align-items-center">
                                    <div class="bg-light d-flex justify-content-center align-items-center"
                                        style="border: 1px solid #ddd;">
                                        <img src="{{ asset($product->image_url1) }}" alt="{{ $product->name }}"
                                            style="max-width: 100%; max-height: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <h5>{{ $product->name }}</h5>
                                    <h6 class="truncated-description">{{ $product->description }}</h6>
                                    <div>
                                        <span style="text-decoration: line-through; color:#c7c7c7">
                                            ${{ $product->original_price }}
                                        </span>
                                        <span class="ms-1" style="font-size:22px;color:#ef4444">
                                            ${{ $product->discounted_price }}
                                        </span>
                                        <span class="ms-1" style="font-size:12px; color:#00DD21">
                                            {{ round($product->discount_percentage) }}% off
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-wrap align-items-center mt-2">
                                    @if ($product->deal_type === 2)
                                        <div class="d-flex align-items-center">
                                            <div class="form-group">
                                                <label for="service_date" class="form-label">Service Date</label>
                                                <input type="date" id="service_date" name="service_date"
                                                    class="form-control form-control-sm service-date"
                                                    value="{{ old('service_date') }}" min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="form-group ms-2">
                                                <label for="service_time" class="form-label">Service Time</label>
                                                <input type="time" id="service_time" name="service_time"
                                                    class="form-control form-control-sm service-time"
                                                    value="{{ old('service_time') }}" required>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center my-3">
                                            <span class="me-2">Qty</span>
                                            <button class="btn rounded btn-sm decrease-btn"
                                                style="background: #c7c7c75b">-</button>
                                            <input type="text"
                                                class="form-control form-control-sm mx-2 text-center quantity-input"
                                                style="width: 50px;" value="1" readonly>
                                            <button class="btn rounded btn-sm increase-btn"
                                                style="background: #c7c7c75b">+</button>
                                        </div>
                                    @endif
                                    <span class="px-2">
                                        <button class="btn btn-sm btn-danger rounded remove-btn"
                                            style="background: #ef4444; color:#fff;
                                     margin-top: {{ $product->deal_type === 2 ? '30px;' : '3px;' }}">Remove</button>
                                    </span>
                                </div>
                                <hr class="mt-3">
                            </div>
                        @endforeach
                        {{-- @else
                                <div class="text-center">
                                    <p class="text-muted">No Product Found in the Summary page.</p>
                                </div>
                            @endif --}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <p class="text-center mb-0">You have these items in your cart </p>
                    <div class="container mb-4">
                        <div class="card p-3">
                            <!-- Card 1 -->
                            <form action="">
                                @csrf
                                @if ($carts->items->count() > 0)
                                    @foreach ($carts->items as $cart)
                                        <div class="row d-flex align-items-center mb-3">
                                            <div class="col-1">
                                                <input type="checkbox" value="{{ $cart->product->id }}" class="me-1" />
                                            </div>
                                            <div class="col-3">
                                                <img src="{{ asset($cart->product->image_url1) }}"
                                                    alt="{{ $cart->product->name }}" class="img-fluid card_img_cont" />
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column justify-content-start">
                                                    <h5 class="mb-1 fs_common text-truncate" style="max-width: 100%;">
                                                        {{ $cart->product->name }}
                                                    </h5>
                                                    <p class="mb-0 text-muted fs_common text-truncate"
                                                        style="max-width: 100%;">
                                                        {{ $cart->product->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center">
                                        <p class="text-muted">No items found in the cart.</p>
                                    </div>
                                @endif


                                <!-- Add Button -->
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-orange fs_common my-2">Add Item</button>
                                </div>
                            </form>
                            <p>Saved Items</p>
                            @if ($savedItem->count() > 0)
                                @foreach ($savedItem as $list)
                                    <div class="row d-flex align-items-center mb-3">
                                        <div class="col-1">
                                            {{-- <input type="checkbox" value="{{ $list->deal->id }}" class="me-1" /> --}}
                                        </div>
                                        <div class="col-3">
                                            <img src="{{ asset($list->deal->image_url1) }}"
                                                alt="{{ $list->deal->name }}" class="img-fluid card_img_cont" />
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex flex-column justify-content-start">
                                                <h5 class="mb-1 fs_common text-truncate" style="max-width: 100%;">
                                                    {{ $list->deal->name }}
                                                </h5>
                                                <p class="mb-0 text-muted fs_common text-truncate"
                                                    style="max-width: 100%;">
                                                    {{ $list->deal->description }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <form action="{{ route('movetocart') }}" class="d-flex justify-content-end"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $list->deal->id }}">
                                                <button type="submit" style="width: 150px;font-size: 14px;"
                                                    class="btn py-0">
                                                    <u>Move to Cart</u>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center">
                                    <p class="text-muted">No items found in the Saved list.</p>
                                </div>
                            @endif

                            {{-- <div class="d-flex justify-content-end">
                                    <button class="btn btn-orange fs_common my-2">Move to cart</button>
                                </div> --}}
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center my-2">
                @if ($default_address)
                    <button type="submit" class="btn" id="submitBtn"
                        style="padding:14px 36px; background:#00DD21; font-size:22px; color:#fff; text-decoration: none;">
                        Check Out
                    </button>
                @else
                    <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#newAddressModal"
                        style="padding:14px 36px; background:#00DD21; font-size:22px; color:#fff; text-decoration: none;">
                        Check Out
                    </a>
                @endif
            </div>
        </div>
    </section>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            let valid = true;
            const serviceFields = document.querySelectorAll('.service-date, .service-time');
            let firstInvalidField = null;

            serviceFields.forEach(field => {
                const fieldContainer = field.closest('.form-group'); // Correct parent selector
                let errorElement = fieldContainer.querySelector('.error-message');

                if (!field.value) {
                    valid = false;

                    if (!errorElement) {
                        const errorMessage = document.createElement('span');
                        errorMessage.textContent = 'This field is required';
                        errorMessage.style.color = 'red';
                        errorMessage.style.fontSize = '12px';
                        errorMessage.classList.add('error-message');
                        fieldContainer.appendChild(errorMessage);
                    }

                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                } else {
                    if (errorElement) {
                        errorElement.remove();
                    }
                }
            });

            if (!valid) {
                event.preventDefault(); // Prevent form submission

                if (firstInvalidField) {
                    firstInvalidField.focus(); // Focus the first invalid field
                }
            }
        });
    </script>


@endsection
